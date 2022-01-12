<?php

namespace App\Repositories\Addworking\Enterprise;

use Carbon\Carbon;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Events\Addworking\Enterprise\Document\DocumentCreated;
use App\Http\Requests\Addworking\Enterprise\Document\StoreAcceptDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\StoreDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\StoreRejectDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\UpdateDocumentRequest;
use App\Models\Addworking\Common\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Notifications\Addworking\Enterprise\DocumentRejectedNotification;
use App\Repositories\Addworking\Common\CommentRepository;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;

class DocumentRepository extends BaseRepository
{
    protected $model = Document::class;

    protected $comment;
    protected $customerRepository;
    protected $enterpriseRepository;
    protected $complianceEnterpriseRepository;

    public function __construct(
        CommentRepository $comment,
        CustomerRepository $customerRepository,
        AddworkingEnterpriseRepository $enterpriseRepository,
        ComplianceEnterpriseRepository $complianceEnterpriseRepository
    ) {
        $this->comment = $comment;
        $this->customerRepository = $customerRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->complianceEnterpriseRepository = $complianceEnterpriseRepository;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Document::query()
            ->when($filter["document_type"] ?? null, function ($query, $document_type) {
                return $query->whereHas('documentType', function ($query) use ($document_type) {
                    return $query->whereIn('id', Arr::wrap($document_type));
                });
            })
            ->when($filter["vendor"] ?? null, function ($query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter["created_after"] ?? null, function ($query, $created_after) {
                return $query->createdAfter($created_after);
            })
            ->when($filter["created_before"] ?? null, function ($query, $created_before) {
                return $query->createdBefore($created_before);
            })
            ->when($filter["status"] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter["customer"] ?? null, function ($query, $customer) {
                return $query->whereHas('enterprise', function ($query) use ($customer) {
                    $query->whereHas('customers', function ($query) use ($customer) {
                        return $query->whereIn('id', Arr::wrap($customer));
                    });
                });
            })
            ->when($filter["vendor_without_customer"] ?? null, function ($query, $condition) {
                switch ($condition) {
                    case 'yes':
                        $query->has('enterprise.customers');
                        break;
                    case 'no':
                        $query->doesntHave('enterprise.customers');
                        break;
                }
            })
            ->when($filter["type_owner"] ?? null, function ($query, $owner_type) {
                return $query->ownerOfDocumentType($owner_type);
            })
            ->when($filter["document_kind"] ?? null, function ($query, $kind) {
                return $query->whereHas('documentType', function ($query) use ($kind) {
                    return $query->ofType($kind);
                });
            })
            ->when($filter["is_pre_checked"] ?? null, function ($query, $check) {
                return $query->where('is_pre_check', $check)->where('status', Document::STATUS_PENDING);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function generateFilesFromJson(array $uploads, string $enterprise, $document_type): array
    {
        return array_map(function ($uploaded) use ($enterprise, $document_type) {
            static $index = 1;
            $data = Arr::only(json_decode($uploaded, true), ['type', 'data', 'size', 'name']);

            return tap(File::from([
                'mime_type' => $data['type'],
                'content'   => base64_decode($data['data']),
                'size' => $data['size'],
                'path' => $data['name']
            ]), function (File $file) use ($enterprise, $document_type, &$index) {
                $file->name(
                    'enterprise/?/document-type/?/%timestamp%-part?.%ext%',
                    $enterprise,
                    Str::slug($document_type->display_name),
                    $index++
                )->save();
            });
        }, $uploads);
    }

    public function generateFilesFromInputs(array $uploads, string $enterprise, $document_type): array
    {
        return array_map(function ($uploaded) use ($enterprise, $document_type) {
            static $index = 1;

            return tap(File::from($uploaded), function (File $file) use (&$index, $enterprise, $document_type) {
                $file->name(
                    'enterprise/?/document-type/?/%timestamp%-part?.%ext%',
                    $enterprise,
                    Str::slug($document_type->display_name),
                    $index++
                )->save();
            });
        }, $uploads);
    }

    public function createFromRequest(
        StoreDocumentRequest $request,
        Enterprise $enterprise,
        DocumentType $document_type
    ): Document {
        return DB::transaction(function () use ($request, $enterprise, $document_type) {
            $files = $request->hasFile('document_files')
                ? $this->generateFilesFromInputs($request->file('document_files'), $enterprise, $document_type)
                : $this->generateFilesFromJson($request->get('document_files'), $enterprise, $document_type);

            $document = tap(new Document, function (Document $doc) use ($request, $enterprise, $document_type, $files) {
                $doc->fill($request->input('document'))
                    ->enterprise()->associate($enterprise)
                    ->documentType()->associate($document_type)
                    ->save();

                $doc->files()->saveMany($files);
                $doc->save();
            });

            event(new DocumentCreated($document));

            // structure is ['uid-1' => ['content' => "foo"], 'uid-2' => ['content' => "bar"]]
            $document->fields()->sync($request->input('document_type_field'));
            if (! is_null($document->getDocumentType())) {
                ActionTrackingHelper::track(
                    $request->user(),
                    ActionEntityInterface::CREATE,
                    $document,
                    __(
                        'addworking.enterprise.document.tracking.create_document_type',
                        [
                            'document_type_name' => $document_type->display_name
                        ]
                    )
                );
            }

            return $document;
        });
    }

    public function updateFromRequest(Document $document, UpdateDocumentRequest $request): bool
    {
        return DB::transaction(function () use ($request, $document) {
            $input = $request->input('document');

            if ($request->filled('document.reason_for_rejection')) {
                unset($input['reason_for_rejection']);
                $document->reason_for_rejection = App::make(DocumentTypeRejectReasonRepository::class)
                    ->find($request->input('document.reason_for_rejection'))
                    ->getDisplayName();
            }

            $updated = $document->update($input);

            // structure is ['uid-1' => ['content' => "foo"], 'uid-2' => ['content' => "bar"]]
            $document->fields()->sync($request->input('document_type_field'));

            return $updated;
        });
    }

    public function acceptFromRequest(Document $document, StoreAcceptDocumentRequest $request): bool
    {
        $document->status = Document::STATUS_VALIDATED;

        $document->valid_until = $request->input('document.valid_until');
        $document->accepted_at = Carbon::now();
        $document->acceptedBy()->associate($request->user());

        $document->rejected_at = null;
        $document->reason_for_rejection = null;
        $document->rejectedBy()->dissociate();

        if (! is_null($document->getDocumentType())) {
            ActionTrackingHelper::track(
                $request->user(),
                ActionEntityInterface::VALIDATE_DOCUMENT_TYPE,
                $document,
                __(
                    'addworking.enterprise.document.tracking.validate',
                    [
                        'document_type_name' => $document->getDocumentType(),
                    ]
                )
            );
        }
        return $document->save();
    }

    public function rejectFromRequest(Document $document, StoreRejectDocumentRequest $request): bool
    {
        return DB::transaction(function () use ($request, $document) {
            $document->status = Document::STATUS_REJECTED;

            $document->rejected_at = Carbon::now();
            $document->reason_for_rejection = App::make(DocumentTypeRejectReasonRepository::class)
                ->find($request->input('document.reason_for_rejection'))->getDisplayName();

            $document->rejectedBy()->associate($request->user());

            $document->accepted_at = null;
            $document->acceptedBy()->dissociate();

            $comment = $request->filled('comment.content')
                ? $this->comment->createFromRequest($request, "Commentaire de refus")
                : null;

            Notification::send(
                $this->complianceEnterpriseRepository->getVendorComplianceManagers($document->enterprise)->get(),
                new DocumentRejectedNotification($document, $comment)
            );

            if (! is_null($document->getDocumentType())) {
                ActionTrackingHelper::track(
                    $request->user(),
                    ActionEntityInterface::REJECT_DOCUMENT_TYPE,
                    $document,
                    __(
                        'addworking.enterprise.document.tracking.reject',
                        [
                            'document_type_name' => $document->getDocumentType(),
                        ]
                    )
                );

                ActionTrackingHelper::track(
                    $request->user(),
                    ActionEntityInterface::REJECT_DOCUMENT_TYPE_NOTIFICATION,
                    $document,
                    __('addworking.enterprise.document.tracking.reject_notification')
                );
            }

            return $document->save();
        });
    }

    public function isReadyToWorkFor(Enterprise $vendor, Enterprise $customer, string $document_type = null): bool
    {
        return DocumentType::ofLegalForm($vendor->legalForm)
            ->requiredByCustomer($customer)
            ->mandatory()
            ->when($document_type, fn($query, $type) => $query->ofType($type))
            ->get()
            ->every(fn($type) => $vendor->documents()->ofDocumentType($type)->onlyValidated()->exists());
    }

    public function getTypesFor(Enterprise $vendor): array
    {
        $types = [];

        $types['Documents Légaux'] = DocumentType::ofType(DocumentType::TYPE_LEGAL)
            ->requiredByVendor($vendor)
            ->ofLegalForm($vendor->legalForm)
            ->oldest()
            ->get();

        $types['Documents Métier'] = DocumentType::ofType(DocumentType::TYPE_BUSINESS)
            ->requiredByVendor($vendor)
            ->ofLegalForm($vendor->legalForm)
            ->oldest()
            ->get();

        $contract_model_parties = ContractParty::has('contractModelParty')
            ->whereHas('enterprise', function ($query) use ($vendor) {
                return $query->where('id', $vendor->id);
            })
            ->whereHas('contract', function ($query) {
                return $query->where('state', '!=', Contract::STATE_DUE);
            })
            ->pluck('contract_model_party_id');

        $types['Documents Contractuels'] = DocumentType::ofType(DocumentType::TYPE_CONTRACTUAL)
            ->ofLegalForm($vendor->legalForm)
            ->whereHas('contractModelPartyDocumentTypes', function ($query) use ($contract_model_parties) {
                return $query->whereIn('contract_model_party_id', $contract_model_parties);
            })->oldest()->get();

        $types['Documents Contractuels Spécifiques'] = ContractModelDocumentType::whereHas(
            'contractModelParty',
            function ($query) use ($contract_model_parties) {
                return $query->whereIn('id', $contract_model_parties)->whereHas('contractModel', function ($query) {
                    return $query->whereHas('contracts', function ($query) {
                        return $query->whereNotIn('state', [ContractEntityInterface::STATE_DUE])
                        ->orWhereNull('deleted_at');
                    });
                });
            }
        )->whereNull('document_type_id')->oldest()->get();

        return $types;
    }

    public function isValid(Document $document): bool
    {
        if (! $document->exists) {
            return false;
        }

        if ($document->status != Document::STATUS_VALIDATED) {
            return false;
        }

        if (! is_null($document->valid_until) && $document->valid_until->isPast()) {
            return false;
        }

        if ($this->isMissingRequiredField($document)) {
            return false;
        }

        return true;
    }

    public function isExpired(Document $document): bool
    {
        if (! $document->exists) {
            return false;
        }

        if ($document->status == Document::STATUS_OUTDATED) {
            return true;
        }

        if (! is_null($document->valid_until) && $document->valid_until->isPast()) {
            return true;
        }

        return false;
    }

    public function isMissingRequiredField(Document $document): bool
    {
        foreach ($document->documentType->documentTypeFields()->mandatory()->cursor() as $doc_type_field) {
            $field = $document->fields()
                ->whereId($doc_type_field->id)
                ->first();

            if (is_null($field) || is_null($field->pivot->content)) {
                return true;
            }
        }

        return false;
    }

    public function getCustomerSDocumentTypeOfDocument(Document $document)
    {
        return Enterprise::whereHas('documentTypes', function ($query) use ($document) {
            return $query->whereHas('documents', function ($query) use ($document) {
                return $query->where('id', $document->id);
            });
        })->first();
    }

    public function isPreCheck(Document $document)
    {
        return Document::where('id', $document->id)->where('is_pre_check', true)->count();
    }

    public function hasExpiredDocuments(Enterprise $enterprise)
    {
        return Document::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->where('status', Document::STATUS_OUTDATED)->count();
    }

    public function getDocumentsOf(Enterprise $enterprise, $active = true)
    {
        return Document::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->whereHas('documentType', function ($query) use ($enterprise, $active) {
            return $query->whereHas('enterprise', function ($query) use ($enterprise, $active) {
                $addworking = $this->enterpriseRepository->getAddworkingEnterprise();
                $customers = $this->customerRepository
                    ->getActiveCustomersAndAncestorsOf($enterprise, $active)
                    ->push($addworking);

                return $query->whereIn('id', $customers->pluck('id'));
            });
            return $query->whereHas('legalForms', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->legalForm->id);
            });
        })->get();
    }

    public function getDocumentRejectReasonText(string $reject_reason): string
    {
        $reasons = [
            Document::REJECTED_FOR_NON_COMPLIANCE => __("document.reason_for_rejection.non_compliance"),
            Document::REJECTED_FOR_INCOMPLETE => __("document.reason_for_rejection.document_incomplete"),
            Document::REJECTED_FOR_EXPIRATION => __("document.reason_for_rejection.document_outdated"),
        ];

        return array_key_exists($reject_reason, $reasons) ? $reasons[$reject_reason] : $reject_reason;
    }

    /**
     * @param Document $document
     * @return bool
     */
    public function checkValidityOf(Document $document): bool
    {
        $valid_from = $document->getValidFrom()->format('Y-m-d');
        $valid_from_plus_validity_period = date(
            "Y-m-d",
            strtotime($valid_from ."+".$document->getDocumentType()->getValidityPeriod()." days")
        );

        if (! is_null($document->getDocumentType()->getDeadlineDate())) {
            return $valid_from_plus_validity_period <= $document->getDocumentType()->getDeadlineDate();
        } else {
            return $valid_from_plus_validity_period <= $document->getValidUntil()->format('Y-m-d');
        }
    }
}
