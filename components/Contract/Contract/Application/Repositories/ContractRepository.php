<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractNotification;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Notifications\ContractNeedsDocumentsNotification;
use Components\Contract\Contract\Application\Notifications\ContractNeedsVariablesValuesNotification;
use Components\Contract\Contract\Application\Notifications\NewContractToSendToSignatureNotification;
use Components\Contract\Contract\Application\Notifications\NewContractToSignNotification;
use Components\Contract\Contract\Application\Notifications\NewContractToValidateOnYousignNotification;
use Components\Contract\Contract\Application\Notifications\RefusedContractNotification;
use Components\Contract\Contract\Application\Notifications\RequestContractVariableValueNotification;
use Components\Contract\Contract\Domain\Exceptions\ContractCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Components\Contract\Contract\Application\Notifications\SignedContractNotification;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContractRepository implements ContractRepositoryInterface
{
    public function find(string $id): ?ContractEntityInterface
    {
        return Contract::where('id', $id)->first();
    }

    public function make($data = []): ContractEntityInterface
    {
        return new Contract($data);
    }

    public function save(ContractEntityInterface $contract)
    {
        try {
            $contract->save();
        } catch (ContractCreationFailedException $exception) {
            throw $exception;
        }

        $contract->refresh();

        return $contract;
    }

    public function list(
        User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $query = Contract::query()
        ->with('enterprise', 'contractModel')
        ->whereNull('parent_id')
        ->whereNull('archived_at')
        ->when($filter['states'] ?? null, function ($query, $states) use ($user) {
            return Contract::query()
                ->with('enterprise', 'contractModel')
                ->whereNull('parent_id')
                ->filterState($states, $user);
        })
        ->where(function ($query) use ($user) {
            return $query
                ->whereHas('parties', function ($query) use ($user) {
                    return $query->whereHas('enterprise', function ($query) use ($user) {
                        return $query->whereIn('id', $user->enterprises->pluck('id'));
                    });
                })
                ->orWhereHas('enterprise', function ($query) use ($user) {
                    return $query->whereIn('id', $user->enterprises->pluck('id'));
                });
        });

        $workfields = [];

        if (App::make(SectorRepository::class)->entreprisesBelongsToConstructionSector($user->enterprises)) {
            $workfields = WorkField::whereHas('workFieldContributors', function ($query) use ($user) {
                return $query->whereHas('contributor', function ($query) use ($user) {
                    return $query->where('id', $user->id);
                });
            })->get()->pluck('id')->toArray();
        }

        if (! empty($workfields)) {
            $query->whereHas('workfield', function ($query) use ($workfields) {
                $query->whereIn('id', $workfields);
            });
        }

        return $query->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
            return $query->filterEnterprise($enterprises);
        })
        ->when($filter['parties'] ?? null, function ($query, $parties) {
            return $query->filterParties($parties);
        })->when($filter['models'] ?? null, function ($query, $models) {
            return $query->filterModels($models);
        })
        ->when($filter['creators'] ?? null, function ($query, $creators) {
            return $query->filterCreators($creators);
        })
        ->when($filter['work_fields'] ?? null, function ($query, $work_fields) {
            return $query->filterWorkFields($work_fields);
        })
        ->when($filter['expiring_contracts'] ?? null, function ($query, $day) {
            return $query->filterExpiringContracts($day);
        })
        ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
            return $query->search($search, $operator, $field_name);
        })->latest()->paginate($page ?? 25);
    }

    public function countContractsOfState(User $user, ?string $state = null)
    {
        return Contract::whereNull('parent_id')
            ->where(function ($query) use ($user) {
                return $query
                    ->whereHas('parties', function ($query) use ($user) {
                        return $query->whereHas('enterprise', function ($query) use ($user) {
                            return $query->where('id', $user->enterprise->id);
                        });
                    })
                    ->orWhereHas('enterprise', function ($query) use ($user) {
                        return $query->where('id', $user->enterprise->id);
                    });
            })
            ->when($state ?? null, function ($query) use ($state) {
                return $query->filterState($state);
            })
            ->count();
    }

    public function findByNumber(string $number, ?bool $trashed = null): ?ContractEntityInterface
    {
        if ($trashed) {
            return Contract::withTrashed()->where('number', $number)->first();
        }
        return Contract::where('number', $number)->first();
    }

    public function getAvailableStatuses(): array
    {
        return [
            Contract::STATUS_PUBLISHED,
            Contract::STATUS_SIGNED,
            Contract::STATUS_DRAFT,
            Contract::STATUS_READY_TO_GENERATE,
            Contract::STATUS_GENERATING,
            Contract::STATUS_GENERATED,
            Contract::STATUS_UPLOADING,
            Contract::STATUS_UPLOADED,
            Contract::STATUS_READY_TO_SIGN,
            Contract::STATUS_BEING_SIGNED,
            Contract::STATUS_CANCELLED,
            Contract::STATUS_ACTIVE,
            Contract::STATUS_INACTIVE,
            Contract::STATUS_EXPIRED,
            Contract::STATUS_ERROR,
            Contract::STATUS_DECLINED,
            Contract::STATUS_LOCKED,
            Contract::STATUS_UNKNOWN,
        ];
    }

    public function getAvailableStates(bool $trans = false): array
    {
        $translation_base = "components.contract.contract.application.views.contract._state";

        $states  = [
            ContractEntityInterface::STATE_IS_READY_TO_GENERATE => __("{$translation_base}.is_ready_to_generate"),
            ContractEntityInterface::STATE_DRAFT => __("{$translation_base}.draft"),
            ContractEntityInterface::STATE_GENERATED => __("{$translation_base}.generated"),
            ContractEntityInterface::STATE_TO_VALIDATE => __("{$translation_base}.to_validate"),
            ContractEntityInterface::STATE_TO_SIGN => __("{$translation_base}.to_sign_waiting_for_signature"),
            ContractEntityInterface::STATE_SIGNED => __("{$translation_base}.signed"),
            ContractEntityInterface::STATE_IN_PREPARATION => __("{$translation_base}.in_preparation"),
            ContractEntityInterface::STATE_MISSING_DOCUMENTS => __("{$translation_base}.missing_documents"),
            ContractEntityInterface::STATE_DECLINED => __("{$translation_base}.declined"),
            ContractEntityInterface::STATE_ACTIVE => __("{$translation_base}.active"),
            ContractEntityInterface::STATE_INACTIVE => __("{$translation_base}.inactive"),
            ContractEntityInterface::STATE_DUE => __("{$translation_base}.due"),
            ContractEntityInterface::STATE_CANCELED => __("{$translation_base}.canceled"),
            ContractEntityInterface::STATE_UNKNOWN => __("{$translation_base}.unknown"),
            ContractEntityInterface::STATE_ARCHIVED => __("{$translation_base}.archived"),
        ];

        return $trans ? $states : array_keys($states);
    }

    public function getFilterAvailableStates(bool $trans = false): array
    {
        $translation_base = "components.contract.contract.application.views.contract._state";

        $states  = [
            ContractEntityInterface::STATE_DRAFT => __("{$translation_base}.draft"),
            ContractEntityInterface::STATE_IN_PREPARATION => __("{$translation_base}.in_preparation"),
            ContractEntityInterface::STATE_MISSING_DOCUMENTS => __("{$translation_base}.missing_documents"),
            ContractEntityInterface::STATE_GENERATED => __("{$translation_base}.generated"),
            ContractEntityInterface::STATE_TO_VALIDATE => __("{$translation_base}.to_validate"),
            ContractEntityInterface::STATE_INTERNAL_VALIDATION => __("{$translation_base}.internal_validation"),
            ContractEntityInterface::STATE_UNDER_VALIDATION => __("{$translation_base}.under_validation"),
            ContractEntityInterface::STATE_TO_SIGN => __("{$translation_base}.to_sign"),
            ContractEntityInterface::STATE_WAITING_FOR_SIGNATURE => __("{$translation_base}.waiting_for_signature"),
            ContractEntityInterface::STATE_SIGNED => __("{$translation_base}.signed"),
            ContractEntityInterface::STATE_ACTIVE => __("{$translation_base}.active"),
            ContractEntityInterface::STATE_DECLINED => __("{$translation_base}.declined"),
            ContractEntityInterface::STATE_DUE => __("{$translation_base}.due"),
            ContractEntityInterface::STATE_INACTIVE => __("{$translation_base}.inactive"),
            ContractEntityInterface::STATE_ARCHIVED => __("{$translation_base}.archived"),
            ContractEntityInterface::STATE_UNKNOWN => __("{$translation_base}.unknown"),
            ContractEntityInterface::STATE_IS_READY_TO_GENERATE => __("{$translation_base}.is_ready_to_generate"),
            ContractEntityInterface::STATE_CANCELED => __("{$translation_base}.canceled"),
        ];

        return $trans ? $states : array_keys($states);
    }

    public function listAsSupport(
        ?User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $query = Contract::query()
        ->with('enterprise', 'contractModel')
        ->when($filter['states'] ?? null, function ($query, $states) use ($user) {
            return $query->filterState($states, $user);
        })
        ->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
            return $query->filterEnterprise($enterprises);
        })
        ->when($filter['parties'] ?? null, function ($query, $parties) {
            return $query->filterParties($parties);
        })
        ->when($filter['models'] ?? null, function ($query, $models) {
            return $query->filterModels($models);
        })
        ->when($filter['creators'] ?? null, function ($query, $creators) {
            return $query->filterCreators($creators);
        })
        ->when($filter['work_fields'] ?? null, function ($query, $work_fields) {
            return $query->filterWorkFields($work_fields);
        })
        ->when($filter['expiring_contracts'] ?? null, function ($query, $day) {
            return $query->filterExpiringContracts($day);
        })
        ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
            return $query->search($search, $operator, $field_name);
        });

        if (!($filter && array_key_exists('states', $filter)
            && in_array(ContractEntityInterface::STATE_ARCHIVED, $filter['states']))) {
            $query->whereNull('archived_at');
        }

        return $query->latest()
        ->paginate($page ?? 25);
    }

    public function listAsSupportForEnterprise(
        Enterprise $enterprise,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null
    ) {
        return Contract::query()
        ->with('enterprise', 'contractModel')
        ->where(function ($query) use ($enterprise) {
            return $query
            ->whereHas('parties', function ($query) use ($enterprise) {
                return $query->whereHas('enterprise', function ($query) use ($enterprise) {
                    return $query->where('id', $enterprise->id);
                });
            })
            ->orWhereHas('enterprise', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            });
        })
        ->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
            return $query->filterEnterprise($enterprises);
        })
        ->when($filter['statuses'] ?? null, function ($query, $statuses) {
            return $query->filterStatus($statuses);
        })
        ->when($filter['parties'] ?? null, function ($query, $parties) {
            return $query->filterParties($parties);
        })
        ->when($search ?? null, function ($query, $search) {
            return $query->search($search);
        })
        ->latest()
        ->paginate($page ?? 25);
    }

    public function getPartiesWithoutOwner(ContractEntityInterface $contract)
    {
        return $this->getSignatoryParties($contract)->filter(function ($party) use ($contract) {
            if ($party->getEnterprise()) {
                return $party->getEnterprise()->id != $contract->getEnterprise()->id;
            } else {
                return false;
            }
        });
    }

    public function isDraft(ContractEntityInterface $contract): bool
    {
        return $contract->getStatus() == Contract::STATUS_DRAFT;
    }

    public function delete(ContractEntityInterface $contract): bool
    {
        $contract->deletedBy()->associate(App::make(UserRepository::class)->connectedUser())->save();

        return $contract->delete();
    }

    public function isDeleted(int $number): bool
    {
        return ! is_null(Contract::withTrashed()->where('number', $number)->first()->getDeletedAt());
    }

    public function isPartyOf(User $user, ContractEntityInterface $contract): bool
    {
        foreach ($this->getSignatoryParties($contract) as $party) {
            if ($user->enterprises->contains($party->getEnterprise())) {
                return true;
            }
        }

        return false;
    }

    public function isVendorAndPartyOf(User $user, ContractEntityInterface $contract): bool
    {
        foreach ($this->getSignatoryParties($contract) as $party) {
            if ($user->enterprises->contains($party->getEnterprise())
                && $party->getEnterprise()->isVendor()
                && ! $party->getEnterprise()->isHybrid()
            ) {
                return true;
            }
        }

        return false;
    }

    public function isValidatorOf(User $user, ContractEntityInterface $contract): bool
    {
        foreach ($this->getValidatorParties($contract) as $party) {
            if ($user->enterprises->contains($party->getEnterprise())) {
                return true;
            }
        }

        return false;
    }

    public function isCreator(User $user, ContractEntityInterface $contract): bool
    {
        return !is_null($contract->getCreatedBy()) && $contract->getCreatedBy()->is($user);
    }

    public function sendNotificationRequestDocuments(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        $is_followup = true
    ) {
        $users_to_notify = App::make(UserRepositoryInterface::class)
            ->getVendorComplianceManagerOf($contract_party->getEnterprise(), $contract_party);

        Notification::send(
            $contract_party->getSignatory(),
            new ContractNeedsDocumentsNotification(
                $contract,
                $contract_party,
                $is_followup
            )
        );

        foreach ($users_to_notify as $user) {
            Notification::send(
                $user,
                new ContractNeedsDocumentsNotification(
                    $contract,
                    $contract_party,
                    $is_followup
                )
            );
        }
    }

    public function sendNotificationRequestContractVariableValue(
        ContractEntityInterface $contract,
        $user_to_request,
        $url
    ) {
        $parties = App::make(ContractRepositoryInterface::class)->getSignatoryParties($contract);
        $party_1 = $parties->where('order', 1)->first();
        $party_2 = $parties->where('order', 2)->first();

        Notification::send(
            $user_to_request,
            new RequestContractVariableValueNotification(
                $contract,
                $url,
                $party_1,
                $party_2
            )
        );
    }

    public function sendNotificationToSignContract(
        Contract $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ): bool {
        if (!$is_followup) {
            $notification = App::make(ContractNotificationRepository::class)
                ->findNotification(
                    $contract,
                    $party_to_notify->getSignatory(),
                    ContractNotificationEntityInterface::REQUEST_SIGNATURE
                );
            if (!is_null($notification)) {
                return false;
            }
        }

        Notification::send(
            $party_to_notify->getSignatory(),
            new NewContractToSignNotification(
                $contract,
                $party_to_notify,
                $is_followup
            )
        );
        return true;
    }

    public function sendNotificationToValidateContractOnYousign(
        Contract $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ): bool {
        if (!$is_followup) {
            $notification = App::make(ContractNotificationRepository::class)
                ->findNotification(
                    $contract,
                    $party_to_notify->getSignatory(),
                    ContractNotificationEntityInterface::REQUEST_VALIDATION_ON_YOUSIGN
                );
            if (!is_null($notification)) {
                return false;
            }
        }

        Notification::send(
            $party_to_notify->getSignatory(),
            new NewContractToValidateOnYousignNotification(
                $contract,
                $party_to_notify,
                $is_followup
            )
        );
        return true;
    }

    public function sendNotificationToSendContractToSignature(Contract $contract): bool
    {
        $user_to_notify = $contract->getCreatedBy();
        if (!$user_to_notify) {
            return false;
        }

        $is_notification_sent = App::make(ContractNotificationRepository::class)
            ->notificationExists(
                $contract,
                [ContractNotificationEntityInterface::REQUEST_SEND_CONTRACT_TO_SIGNATURE],
                [ContractNotificationEntityInterface::REQUEST_DOCUMENTS]
            );

        if ($is_notification_sent) {
            return false;
        }

        Notification::send(
            $user_to_notify,
            new NewContractToSendToSignatureNotification(
                $contract,
                $user_to_notify
            )
        );
        App::make(ContractNotificationRepository::class)
            ->createRequestSendToSignatureNotification(
                $contract,
                $user_to_notify
            );

        return true;
    }

    public function isReadyToGenerate(ContractEntityInterface $contract): bool
    {
        switch (true) {
            case count($this->getSignatoryParties($contract)) < 2:
                return false;

            case is_null($contract->getContractModel()):
                return true;

            case ! $this->checkIfAllDocumentsOfContractStatusIsValidated($contract):
                return false;

            case $this->checkIfHasPartsWithContractModel($contract):
                return false;

            case count($contract->getContractModel()->getVariables()):
                if (! count($contract->getContractVariables())) {
                    return false;
                }
                return $contract->getContractVariables()->every(function ($variable) {
                    return ! is_null($variable->getValue());
                });

            default:
                return true;
        }
    }

    public function checkIfAllDocumentsOfContractStatusIsValidated(ContractEntityInterface $contract): bool
    {
        if ($contract->getContractModel()) {
            foreach ($this->getSignatoryParties($contract) as $party) {
                foreach ($this->getDocumentsOfContract($contract) as $type) {
                    if ($party->getContractModelParty() == $type->getContractModelParty()) {
                        if (! is_null($type->getDocumentType()) && ! in_array(
                            $party->getEnterprise()->legalForm()->first()->id,
                            $type->getDocumentType()->legalForms()->get()->pluck('id')->toArray()
                        )) {
                            continue;
                        } elseif (is_null($type->getDocumentType())) {
                            if (is_null($this->getDocumentOfContractModelDocumentType($contract, $party, $type))) {
                                return false;
                            }
                        } else {
                            $document = $type->getDocumentType()->documents()->ofEnterprise($party->getEnterprise())
                                ->latest()->first();
                            if (is_null($document) || $document->status != Document::STATUS_VALIDATED) {
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    public function checkIfAllDocumentsOfContractStatusIsValidatedForParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    ): bool {
        if ($this->hasContractModel($contract)) {
            foreach ($this->getDocumentsOfContract($contract) as $type) {
                if ($contract_party->getContractModelParty() == $type->getContractModelParty()) {
                    if (! is_null($type->getDocumentType()) && in_array(
                        $contract_party->getEnterprise()->legalForm()->first()->id,
                        $type->getDocumentType()->legalForms()->get()->pluck('id')->toArray()
                    )) {
                        $document = $type
                            ->getDocumentType()
                            ->documents()
                            ->ofEnterprise(
                                $contract_party->getEnterprise()
                            )
                            ->latest()->first();
                        if (is_null($document) || $document->status != Document::STATUS_VALIDATED) {
                            return false;
                        }
                    } elseif (is_null($type->getDocumentType())) {
                        if (is_null($this->getDocumentOfContractModelDocumentType($contract, $contract_party, $type))) {
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    public function checkIfSendNotificationDocumentsToParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    ): bool {
        if ($this->hasContractModel($contract)) {
            foreach ($this->getDocumentsOfContract($contract) as $type) {
                if ($contract_party->getContractModelParty() == $type->getContractModelParty()) {
                    if (! is_null($type->getDocumentType()) && in_array(
                        $contract_party->getEnterprise()->legalForm()->first()->id,
                        $type->getDocumentType()->legalForms()->get()->pluck('id')->toArray()
                    )) {
                        $document = $this->getDocumentOfDocumentType($type, $contract_party);
                        if (is_null($document)
                        || in_array($document->status, [Document::STATUS_OUTDATED, Document::STATUS_REJECTED])) {
                            return true;
                        }
                    } elseif (is_null($type->getDocumentType())) {
                        if (is_null($this->getDocumentOfContractModelDocumentType($contract, $contract_party, $type))) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    private function getDocumentsOfContract(ContractEntityInterface $contract, bool $validation_required = true)
    {
        return ContractModelDocumentType::whereHas(
            'contractModelParty',
            function ($query) use ($contract) {
                $query->whereIn('id', $contract->getContractModel()->getParties()->pluck('id'));
            }
        )->where('validation_required', $validation_required)
        ->get();
    }

    public function isOwnerOf(User $auth_user, ContractEntityInterface $contract): bool
    {
        return $auth_user->enterprises->contains($contract->getEnterprise());
    }

    public function generate(ContractEntityInterface $contract) : string
    {
        $contract_model_parts = $contract->getContractModel()->getParts();
        foreach ($contract_model_parts as $contract_model_part) {
            $file = $contract_model_part->getFile();
            if ($contract_model_part->getShouldCompile()) {
                $contract_variables = App::make(ContractVariableRepository::class)->getAllVariables($contract);
                // todo : /\ double check method
                // todo:       ajouter les variables au HTML
            }
            $contract_part = App::make(ContractPartRepository::class)->make();
            $contract_part->setContract($contract);
            $contract_part->setFile($file);
            $contract_part->setOrder($contract_model_part->getOrder());
            $contract_part->setContractModelPart($contract_model_part, ['order' => $contract_model_part->getOrder()]);
            App::make(ContractPartRepository::class)->save($contract_part);
            // todo:       Ajouter les HTML au pdf
        }

        // todo : retourner le path du pdf
        return 'FAKE PDF PATH';
    }

    public function isAmendment(ContractEntityInterface $contract): bool
    {
        return !is_null($contract->getParent());
    }

    public function hasActiveAmendment(ContractEntityInterface $contract): bool
    {
        $amendments = $contract->getAmendments();
        foreach ($amendments as $amendment) {
            if ($amendment->getState() === ContractEntityInterface::STATE_ACTIVE) {
                return true;
            }
        }
        return false;
    }

    public function updateStatus(ContractEntityInterface $contract, string $status)
    {
        $contract->setStatus($status);
        return $this->save($contract);
    }

    public function checkIfContractIsSigned(ContractEntityInterface $contract): bool
    {
        foreach ($this->getSignatoryParties($contract) as $party) {
            if (is_null($party->getSignedAt())) {
                return false;
            }
        }
        return true;
    }

    public function checkIfContractIsDeclined(ContractEntityInterface $contract): bool
    {
        foreach ($this->getSignatoryParties($contract) as $party) {
            if (! is_null($party->getDeclinedAt())) {
                return true;
            }
        }

        foreach ($this->getValidatorParties($contract) as $party) {
            if (! is_null($party->getDeclinedAt())) {
                return true;
            }
        }

        return false;
    }

    public function checkIfAllPartiesHasSignatory(ContractEntityInterface $contract): bool
    {
        foreach ($this->getSignatoryParties($contract) as $party) {
            if (is_null($party->getSignatory())) {
                return false;
            }
        }
        return true;
    }

    public function canSign(ContractEntityInterface $contract, User $user): bool
    {
        $next_party_to_sign = App::make(ContractPartyRepository::class)
                                ->getNextPartyThatShouldSign($contract);

        if (is_null($next_party_to_sign) || !is_null($next_party_to_sign->getDeclinedAt())) {
            return false;
        }

        return $user->is($next_party_to_sign->getSignatory());
    }

    public function canValidate(
        ContractEntityInterface $contract,
        User $user,
        ?ContractPartyEntityInterface $party
    ): bool {
        if (isset($party) && (!$user->is($party->getSignatory()) || !is_null($party->getDeclinedAt()))) {
            return false;
        }

        $next_party_to_sign = App::make(ContractPartyRepository::class)
            ->getNextPartyThatShouldValidate($contract);

        if (is_null($next_party_to_sign)) {
            return false;
        }

        return $user->is($next_party_to_sign->getSignatory());
    }

    public function checkIfHasPartsWithContractModel(ContractEntityInterface $contract): bool
    {
        if (is_null($contract->getContractModel())) {
            return false;
        }

        foreach ($this->getContractParts($contract) as $contract_part) {
            if (!is_null($contract_part->getContractModelPart())) {
                return true;
            }
        }
        return false;
    }

    public function getValidUntilDate(ContractEntityInterface $contract)
    {
        $date = $contract->getValidUntil();

        foreach ($contract->getAmendments() as $amendment) {
            if ($amendment->getValidUntil() > $date
                && in_array(
                    $amendment->getState(),
                    [
                        ContractEntityInterface::STATE_ACTIVE,
                        ContractEntityInterface::STATE_SIGNED,
                        ContractEntityInterface::STATE_DUE
                    ]
                )
            ) {
                $date = $amendment->getValidUntil();
            }
        }

        return $date;
    }

    public function findByYousignProcedureId(string $id): ?ContractEntityInterface
    {
        return Contract::where('yousign_procedure_id', $id)->first();
    }

    public function getSearchableAttributes(): array
    {
        return [
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_NAME =>
                'components.contract.contract.application.views.contract._table_head.name',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_EXTERNAL_IDENTIFIER =>
                'components.contract.contract.application.views.contract._table_head.external_identifier',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_NUMBER =>
                'components.contract.contract.application.views.contract._table_head.contract_number',
        ];
    }

    public function checkIfStateIsSigned(ContractEntityInterface $contract): bool
    {
        return $contract->getState() == ContractEntityInterface::STATE_SIGNED;
    }

    public function getContractParts(
        ContractEntityInterface $contract,
        bool $without_hidden = false,
        bool $hidden_only = false
    ) {
        return $contract
            ->getParts()
            ->where('is_used_in_contract_body', true)
            ->filter(function ($part) use ($without_hidden, $hidden_only) {
                switch (true) {
                    case $without_hidden:
                        return ! $part->getIsHidden();

                    case $hidden_only:
                        return $part->getIsHidden();
                }

                return true;
            });
    }

    public function getNonBodyContractPart(ContractEntityInterface $contract)
    {
        return ContractPart::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_used_in_contract_body', false)
        ->get();
    }

    public function orderContractParts(ContractEntityInterface $contract): void
    {
        $parts = $this->getContractParts($contract, true)->sortBy('order');

        foreach ($this->getContractParts($contract, false, true)->sortBy('order') as $hidden) {
            $parts->push($hidden);
        }

        $i = 1;
        foreach ($parts as $part) {
            $part->setOrder($i);
            $part->save();
            $i++;
        }
    }

    public function hasYousignProcedureId(ContractEntityInterface $contract): bool
    {
        return !is_null($contract->getYousignProcedureId());
    }

    public function hasContractModel(ContractEntityInterface $contract)
    {
        return !is_null($contract->getContractModel());
    }

    public function isDateActive(ContractEntityInterface $contract): bool
    {
        $now = Carbon::now();

        foreach ($this->getLinkedContracts($contract) as $contract) {
            $valid_from = $contract->getValidFrom();
            $valid_until = $contract->getValidUntil();

            if (!isset($valid_until) && !isset($valid_from)) {
                return true;
            }

            if (!isset($valid_from) && isset($valid_until) && $valid_until > $now) {
                return true;
            }

            if (!isset($valid_until) && $valid_from < $now) {
                return true;
            }

            if (isset($valid_until)
                && isset($valid_from)
                && $now->isBetween($valid_from, $valid_until)) {
                return true;
            }
        }

        return false;
    }

    public function isDateDue(ContractEntityInterface $contract): bool
    {
        $now = Carbon::now();
        $at_least_one_is_due = false;

        foreach ($this->getLinkedContracts($contract) as $contract) {
            $valid_from = $contract->getValidFrom();
            $valid_until = $contract->getValidUntil();

            if (!isset($valid_until) && !isset($valid_from)) {
                return false;
            }

            if (!isset($valid_until) && $valid_from < $now) {
                return false;
            }

            if (!isset($valid_from) && $valid_until > $now) {
                return false;
            }

            if (isset($valid_until)
                && isset($valid_from)
                && Carbon::now()->isBetween($valid_from, $valid_until)) {
                return false;
            }

            if ($valid_from < $now && $valid_until < $now) {
                $at_least_one_is_due = true;
            }
        }

        return $at_least_one_is_due;
    }

    private function getLinkedContracts(ContractEntityInterface $contract, bool $ready_contracts_only = true)
    {
        $query = Contract::whereHas('parent', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        });
        if ($ready_contracts_only) {
            $query = $query->whereIn(
                'state',
                [
                    ContractEntityInterface::STATE_SIGNED,
                    ContractEntityInterface::STATE_DUE,
                    ContractEntityInterface::STATE_ACTIVE,
                ]
            );
        }
        $contracts = $query->get();
        $contracts->add($contract);
        return $contracts;
    }

    public function canBeRegenerated(ContractEntityInterface $contract): bool
    {
        if ($this->hasYousignProcedureId($contract) || !$this->hasContractModel($contract)) {
            return false;
        }

        return true;
    }

    public function getSignatoryParties(ContractEntityInterface $contract)
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', false)
        ->orderBy('order', 'asc')
        ->get();
    }

    public function getValidatorParties(ContractEntityInterface $contract)
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', true)
        ->get();
    }

    public function getPendingValidatorParties(ContractEntityInterface $contract)
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', true)
        ->whereNull('validated_at')
        ->get();
    }

    public function getContractsBetween($enterprises, bool $without_mission = false)
    {
        return Contract::query()
            ->when($without_mission, function ($query) {
                $query->doesntHave('mission');
            })
            ->ofEnterprises($enterprises)
            ->get();
    }

    public function getDocumentOfContractModelDocumentType(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        ContractModelDocumentType $type
    ) {
        $enterprise = $contract_party->getEnterprise();
        return  Document::whereHas('contractModelPartyDocumentType', function ($query) use ($type) {
            return $query->where('id', $type->id);
        })->whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->latest()->first();
    }

    public function sendNotificationForSignedContract(Contract $contract, User $user)
    {
        if (!App::make(ContractNotificationRepository::class)->exists(
            $contract,
            $user,
            ContractNotification::SIGNED_CONTRACT
        )) {
            App::make(ContractNotificationRepository::class)
                ->createSignedContractNotification($contract, $user);
            Notification::send(
                $user,
                new SignedContractNotification(
                    $contract,
                    $user
                )
            );
        }
    }

    public function sendNotificationForRefusedContract(Contract $contract, User $user)
    {
        if (!App::make(ContractNotificationRepository::class)->exists(
            $contract,
            $user,
            ContractNotification::REFUSED_CONTRACT
        )) {
            App::make(ContractNotificationRepository::class)
                ->createRefusedContractNotification($contract, $user);
            Notification::send(
                $user,
                new RefusedContractNotification(
                    $contract,
                    $user
                )
            );
        }
    }

    public function getDocumentOfDocumentType(
        ContractModelDocumentType $type,
        ContractPartyEntityInterface $contract_party
    ) {
        return $type
            ->getDocumentType()
            ->documents()
            ->ofEnterprise($contract_party->getEnterprise())
            ->latest()->first();
    }

    public function getMaxOrderofValidator(ContractEntityInterface $contract) : int
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', true)->max('order') ?? 0;
    }

    public function download(ContractEntityInterface $contract)
    {
        return response()->download($this->generateZip($contract));
    }

    public function generateZip(ContractEntityInterface $contract)
    {
        $dir_to_zip = storage_path('temp/' . uniqid("contract_"));
        $contract_name = Str::slug($contract->getName());
        $zip = storage_path("temp/{$contract_name}.zip");

        if (! is_dir($dir_to_zip)) {
            mkdir($dir_to_zip);
        }

        $zip_arg = escapeshellarg($zip);
        $dir_arg = escapeshellarg($dir_to_zip);

        foreach ($contract->getParts() as $part) {
            $file = $part->getFile();
            $path = "{$dir_to_zip}/".$part->getName().".{$file->extension}";

            if (! file_put_contents($path, $file->content)) {
                throw new \RuntimeException("unable to write '{$path}'");
            }
        }

        // -r stands for recursive
        // -j stands for junk (forget about paths in Zip archive)
        exec($cmd = "zip -j -r {$zip_arg} {$dir_arg}", $output, $return_var);

        if (! $return_var == "0") {
            throw new \RuntimeException("unable to run command '{$cmd}'");
        }

        return $zip;
    }

    public function getWorkFieldsAttachedToContract()
    {
        return WorkField::whereNull('archived_at')->whereHas('contracts')->get();
    }

    public function generateDocumentsZip(ContractEntityInterface $contract)
    {
        $dir_to_zip = storage_path('temp/' . uniqid("contract_"));
        $contract_name = Str::slug($contract->getName());
        $zip = storage_path("temp/{$contract_name}_documents_".date('Ymd_His').".zip");

        if (! is_dir($dir_to_zip)) {
            mkdir($dir_to_zip);
        }

        $zip_arg = escapeshellarg($zip);
        $dir_arg = escapeshellarg($dir_to_zip);

        $document_types = $this->getContractModelDocumentTypeOfContract($contract);

        foreach ($contract->getParties() as $party) {
            foreach ($document_types as $document_type) {
                if (! is_null($document_type->getDocumentType())) {
                    $doc = Document::whereHas('enterprise', function ($query) use ($party) {
                        return $query->where('id', $party->getEnterprise()->id);
                    })->whereHas('documentType', function ($query) use ($document_type) {
                        return $query->where('id', $document_type->getDocumentType()->id);
                    })->whereIn('status', [Document::STATUS_VALIDATED, Document::STATUS_OUTDATED])
                    ->latest()->first();
                } else {
                    $doc = Document::whereHas('contractModelPartyDocumentType', function ($query) use ($document_type) {
                        return $query->where('id', $document_type->id);
                    })->whereHas('contract', function ($query) use ($contract) {
                        return $query->where('id', $contract->getId());
                    })->latest()->first();
                }

                if (! is_null($doc)) {
                    $files = $doc->files()->latest()->get();
                    foreach ($files as $file) {
                        $path = "{$dir_to_zip}/".$document_type->getDisplayName().".{$file->extension}";

                        if (! file_put_contents($path, $file->content)) {
                            throw new \RuntimeException("unable to write '{$path}'");
                        }
                    }
                }
            }
        }
        
        // -r stands for recursive
        // -j stands for junk (forget about paths in Zip archive)
        exec($cmd = "zip -j -r {$zip_arg} {$dir_arg}", $output, $return_var);

        if (! $return_var == "0") {
            throw new \RuntimeException("unable to run command '{$cmd}'");
        }

        return $zip;
    }

    public function downloadDocuments(ContractEntityInterface $contract)
    {
        return response()->download($this->generateDocumentsZip($contract));
    }

    public function getContractModelDocumentTypeOfContract(ContractEntityInterface $contract)
    {
        return ContractModelDocumentType::whereHas('contractModelParty', function ($query) use ($contract) {
            return $query->whereHas('contractModel', function ($query) use ($contract) {
                return $query->whereHas('contracts', function ($query) use ($contract) {
                    return $query->where('id', $contract->getId());
                });
            });
        })->latest()->get();
    }

    public function getContractFacadeState(ContractEntityInterface $contract, ?User $user = null): ?string
    {
        $state = $contract->getState();
        if (!is_null($user)) {
            if ($state === $contract::STATE_TO_SIGN) {
                if (!App::make(ContractPartyRepositoryInterface::class)->isNextPartyThatShouldSign($user, $contract)) {
                    $state = ContractEntityInterface::STATE_WAITING_FOR_SIGNATURE;
                }
            }

            if ($state === $contract::STATE_TO_VALIDATE) {
                if (App::make(UserRepositoryInterface::class)->checkIfUserHasAccessTo($user, $contract)) {
                    if (!App::make(ContractPartyRepositoryInterface::class)
                        ->isNextPartyThatShouldValidate($user, $contract)) {
                        $state = ContractEntityInterface::STATE_INTERNAL_VALIDATION;
                    }
                } else {
                    $state = ContractEntityInterface::STATE_UNDER_VALIDATION;
                }
            }
        }
        return $state;
    }

    public function checkIfUserCanCallBackContract(User $user, Contract $contract): bool
    {
        $signatory_parties = $this->getSignatoryParties($contract);

        foreach ($signatory_parties as $party) {
            if ($user->is($party->getSignatory()) && $user->enterprises->contains($contract->getEnterprise())) {
                return true;
            }
        }

        return false;
    }

    public function getContractDocumentActions(ContractEntityInterface $contract)
    {
        $documents = $this->getContractDocuments($contract);

        $actions = new Collection([]);
        foreach ($documents as $document) {
            $action = $document->actions;
            if ($action) {
                $actions = $actions->merge($action);
            }
        }

        return $actions->flatten()->unique('id');
    }

    public function getContractPartyEnterprisesIds(ContractEntityInterface $contract)
    {
        $enterprise_id = [];
        foreach ($this->getSignatoryParties($contract) as $party) {
            $enterprise_id[] = $party->getEnterprise()->id;
        }
        return $enterprise_id;
    }

    public function getContractDocuments(ContractEntityInterface $contract)
    {
        $enterprise_id = $this->getContractPartyEnterprisesIds($contract);
        $documents = [];

        if (!empty($enterprise_id) && $this->hasContractModel($contract)) {
            foreach ($this->getDocumentsOfContract($contract) as $type) {
                $document_type = $type
                    ->getDocumentType();
                if ($document_type) {
                    $document = $document_type->documents()
                        ->whereHas('enterprise', function ($query) use ($enterprise_id) {
                            $query->where('id', $enterprise_id);
                        })
                        ->latest()
                        ->first();

                    if ($document) {
                        $documents[] = $document;
                    }
                }
            }
        }

        return $documents;
    }

    public function getWorkfieldOf(ContractEntityInterface $contract): ?WorkField
    {
        $work_field = null;
        $mission = $contract->getMission();

        if ($mission) {
            $work_field = $mission->getWorkField();
            if (is_null($work_field)) {
                $sector_offer = $mission->getSectorOffer();
                if (! is_null($sector_offer)) {
                    $work_field = $sector_offer->getWorkField();
                }
            }
        }

        return $work_field;
    }

    /**
     * @param ContractEntityInterface $contract
     * @return BinaryFileResponse
     * @throws GuzzleException
     */
    public function downloadProofOfSignatureZip(ContractEntityInterface $contract): BinaryFileResponse
    {
        // set zip path and name
        $zip_name = storage_path('temp'.DIRECTORY_SEPARATOR.'signature_proofs_'.time().'.zip');

        // create a new zip file
        $zip = new \ZipArchive();
        $zip->open($zip_name, \ZipArchive::CREATE);

        // get contract signatories
        $parties = $this->getSignatoryParties($contract);

        // get yousign client
        $client = new Yousign;
        foreach ($parties as $party) {
            /* @var ContractParty $party */
            if ($party->getYousignMemberId() !== null && $party->getSignedAt() !== null) {
                // get proof data from yousign thanks to the party user id
                $proof_data = $client->getProofFile($party->getYousignMemberId());

                // get content of pdf
                $file_content = base64_decode($proof_data->body);

                // add pdf to the zip
                $zip->addFromString(snake_case($party->getDenomination()).'.'.uniqid().'.pdf', $file_content);
            }
        }
        // close pdf
        $zip->close();

        // return download pdf response
        return response()->download($zip_name);
    }

    public function getVendorParty(ContractEntityInterface $contract): ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->get()->filter(function ($party) use ($contract) {
            return $party->getEnterprise()->id !== $contract->getEnterprise()->id;
        })->first();
    }

    public function sendNotificationContractNeedsVariablesValues(ContractEntityInterface $contract)
    {
        $is_notification_sent = App::make(ContractNotificationRepository::class)
            ->notificationExists(
                $contract,
                [ContractNotificationEntityInterface::CONTRACT_NEEDS_VARIABLES_VALUES],
                []
            );

        if (! $is_notification_sent) {
            $first_contract_party = App::make(ContractPartyRepositoryInterface::class)
                ->getContractPartyByOrderOf($contract, 1);

            Notification::send(
                $first_contract_party->getSignatory(),
                new ContractNeedsVariablesValuesNotification(
                    $contract,
                    $first_contract_party
                )
            );

            App::make(ContractNotificationRepository::class)
                ->createContractNeedsVariablesValuesNotification($contract, $first_contract_party->getSignatory());
        }
    }
}
