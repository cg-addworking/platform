<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Jobs\ScanComplianceDocumentJob;
use App\Http\Requests\Addworking\Enterprise\Document\StoreAcceptDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\StoreDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\StoreRejectDocumentRequest;
use App\Http\Requests\Addworking\Enterprise\Document\UpdateDocumentRequest;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\DocumentRepository;
use App\Repositories\Addworking\Enterprise\DocumentTypeRepository;
use App\Repositories\Addworking\User\OnboardingProcessRepository;
use App\Repositories\Addworking\User\UserRepository;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Connector\Mindee\Application\Data\UrssafMicroData;
use Components\Connector\Mindee\Application\Data\UrssafSocieteData;
use Components\Connector\Mindee\Application\Helpers\ScanComplianceDocumentHelper;
use Components\Contract\Contract\Application\Jobs\UpdateContractStateByDocumentValidationJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository
    as BusinessTurnoverEnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\GenerateDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DocumentController extends Controller
{
    protected $repository;
    protected $onboardingProcessRepository;
    protected $businessTurnoverEnterpriseRepository;
    protected $userRepository;
    protected $documentTypeRepository;
    protected $documentTypeModelRepository;

    public function __construct(
        DocumentRepository $repository,
        OnboardingProcessRepository $onboardingProcessRepository,
        BusinessTurnoverEnterpriseRepository $businessTurnoverEnterpriseRepository,
        UserRepository $userRepository,
        DocumentTypeRepository $documentTypeRepository,
        DocumentTypeModelRepository $documentTypeModelRepository
    ) {
        $this->repository = $repository;
        $this->onboardingProcessRepository = $onboardingProcessRepository;
        $this->businessTurnoverEnterpriseRepository = $businessTurnoverEnterpriseRepository;
        $this->userRepository = $userRepository;
        $this->documentTypeRepository = $documentTypeRepository;
        $this->documentTypeModelRepository = $documentTypeModelRepository;
    }

    public function index(Enterprise $enterprise)
    {
        $this->authorize('index', [Document::class, $enterprise]);

        $types = $this->repository->getTypesFor($enterprise);

        return view('addworking.enterprise.document.index', compact('enterprise', 'types'));
    }

    public function create(Enterprise $enterprise, Request $request)
    {
        $document_type = DocumentType::findOrFail($request->document_type);

        $this->authorize('create', [Document::class, $enterprise, $document_type]);

        $document = $this->repository->factory()->enterprise()->associate($enterprise)
            ->documentType()->associate($document_type);

        $has_model = false;

        if ($request->has('contract_party')) {
            $contract_party = ContractParty::find($request->input('contract_party'));
            $contract = $contract_party->getContract();

            return view('addworking.enterprise.document.create', compact(
                'document',
                'enterprise',
                'document_type',
                'contract',
                'contract_party',
                'has_model'
            ));
        }

        if ($request->has('contract')) {
            $contract = Contract::find($request->input('contract'));

            return view('addworking.enterprise.document.create', compact(
                'document',
                'enterprise',
                'document_type',
                'contract',
                'has_model'
            ));
        }

        if (is_null($this->businessTurnoverEnterpriseRepository->getLastYearBusinessTurnover($enterprise)) &&
            ! Session::has('business_turnover_skipped') &&
            $this->businessTurnoverEnterpriseRepository->collectBusinessTurnover($enterprise) &&
            ! $this->userRepository->isSupport(Auth::user()) &&
            $this->documentTypeRepository->isLegal($document_type)) {
            $parameters = $request->query() + ['enterprise' => $enterprise];

            Session::put(
                'business_turnover_callback_url',
                route('addworking.enterprise.document.create', $parameters)
            );

            return Redirect::route('business_turnover.create');
        }

        foreach ($document_type->getDocumentTypeModels() as $model) {
            if ($model->getIsPrimary()) {
                $has_model = true;
            }
        }

        return view(
            'addworking.enterprise.document.create',
            compact('document', 'enterprise', 'document_type', 'has_model')
        );
    }

    public function createFrom(Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('create', [Document::class, $enterprise, $document_type]);

        $document = $this->repository->factory()->enterprise()->associate($enterprise)
            ->documentType()->associate($document_type);

        return view(
            'addworking.enterprise.document.create',
            compact('document', 'enterprise', 'document_type')
        );
    }

    public function store(Enterprise $enterprise, StoreDocumentRequest $request)
    {
        $document_type = DocumentType::findOrFail($request->document_type);
        
        if ($request->input('document.choice') == "file") {
            if (config('ocr.document_type_urssaf_enabled')) {
                // check if the scan compliance system is enabled or not
                try {
                    $document = null;
                    // get the helper
                    $scan_compliance_document_helper = new ScanComplianceDocumentHelper();
                    // scan document and extract data
                    $document_data = $scan_compliance_document_helper->getDocumentData(
                        $request,
                        $enterprise,
                        $document_type
                    );
                    if (!is_null($document_data)
                        && !$document_data instanceof UrssafSocieteData
                        && !$document_data instanceof UrssafMicroData
                    ) {
                        // if date of document is not valid then return back with error
                        if (!$scan_compliance_document_helper
                                ->checkComplianceDocumentDate($document_data, $document_type)
                            && ! Auth::user()->isSupport()) {
                            return redirect()->back()->with(
                                warning_status(__('addworking.enterprise.document.create.date_of_file_is_not_valid'))
                            );
                        }
                    }
                    // create the document
                    $document = $this->repository->createFromRequest($request, $enterprise, $document_type);

                    // if we were able to get the document data then run scan validation
                    if (!is_null($document_data)) {
                        ScanComplianceDocumentJob::dispatchSync(
                            $document,
                            $document_data,
                            $scan_compliance_document_helper
                        );
                    }
                } catch (\Exception $e) {
                    Log::error($e);
                    if (is_null($document)) {
                        // make sure the document is created even if we have an error occurring
                        $document = $this->repository->createFromRequest($request, $enterprise, $document_type);
                    }
                    ActionTrackingHelper::track(
                        null,
                        ActionEntityInterface::SCAN_COMPLIANCE_DOCUMENT_ERROR_OCCURRED,
                        $document,
                        __(
                            'addworking.enterprise.document.create.scan_compliance_document_error_occurred',
                            ['time' => Carbon::now()->format('H:i')]
                        )
                    );
                }
            } else {
                $document = $this->repository->createFromRequest($request, $enterprise, $document_type);
            }
        } else {
            $document_type_model = DocumentTypeModel::find($request->input('document.choice'));
            $document = App::make(GenerateDocument::class)
                ->handle(Auth::user(), $enterprise, $document_type_model);

            if (! $document->getDocumentTypeModel()->getRequiresDocuments()) {
                return $this->redirectWhen($document->exists, route('enterprise.document.model.show', [
                    'enterprise' => $enterprise,
                    'document' => $document
                ]));
            } else {
                return $this->redirectWhen($document->exists, route('addworking.enterprise.document.show', [
                    'enterprise' => $enterprise,
                    'document' => $document
                ]));
            }
        }

        if ($request->has('contract_party')) {
            $contract_party = ContractParty::find($request->input('contract_party'));
            $contract = $contract_party->getContract();

            return $this->redirectWhen(
                $document->exists,
                route('contract.party.document.index', [
                    'contract' => $contract,
                    'contract_party' => $contract_party
                ])
            );
        }

        if ($request->has('contract')) {
            $contract = Contract::find($request->input('contract'));

            return $this->redirectWhen($document->exists, route('contract.show', $contract));
        }

        return $this->redirectWhen($document->exists, $document->routes->show);
    }

    public function show(Enterprise $enterprise, Document $document)
    {
        $this->authorize('show', $document);

        return view('addworking.enterprise.document.show', compact('document', 'enterprise'));
    }

    public function edit(Enterprise $enterprise, Document $document)
    {
        $this->authorize('update', $document);

        return view('addworking.enterprise.document.edit', compact('document', 'enterprise'));
    }

    public function update(Enterprise $enterprise, Document $document, UpdateDocumentRequest $request)
    {
        try {
            $updated = $this->repository->updateFromRequest($document, $request);

            UpdateContractStateByDocumentValidationJob::dispatchSync($document);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                abort(501, $e->getMessage());
            }
        }

        if (!$request->ajax()) {
            return $this->redirectWhen($updated, $document->routes->show);
        }
    }

    public function destroy(Enterprise $enterprise, Document $document)
    {
        $this->authorize('destroy', $document);

        $deleted = $document->delete();

        return $this->redirectWhen($deleted, $document->routes->index);
    }

    public function replace(Enterprise $enterprise, Document $document, Request $request)
    {
        $this->authorize('replace', $document);

        $deleted = $document->delete();

        if ($request->has('contract_model_document_type')) {
            return $this->redirectWhen(
                $deleted,
                route('contract.party.document.create_without_document_type', [
                    'contract' => $request->input('contract'),
                    'enterprise' => $enterprise,
                ])."?contract_model_document_type=".$request->input('contract_model_document_type')
            );
        }

        if ($request->has('contract_party')) {
            return $this->redirectWhen(
                $deleted,
                route('addworking.enterprise.document.create', [
                    'enterprise' => $enterprise,
                    'document_type' => $document->documentType->id,
                    'contract_party' => $request->input('contract_party'),
                ])
            );
        }

        return $this->redirectWhen($deleted, "{$document->routes->create}?document_type={$document->documentType->id}");
    }

    public function accept(Enterprise $enterprise, Document $document, Request $request)
    {
        $this->authorize('accept', $document);

        return view('addworking.enterprise.document.accept', @compact('document', 'enterprise'));
    }

    public function storeAccept(Enterprise $enterprise, Document $document, StoreAcceptDocumentRequest $request)
    {
        $accepted = $this->repository->acceptFromRequest($document, $request);

        $customer = $document->documentType->enterprise;

        if ($this->repository->isReadyToWorkFor($enterprise, $customer)) {
            $this->onboardingProcessRepository->updateFromValidatedDocument($enterprise);
        }

        UpdateContractStateByDocumentValidationJob::dispatchSync($document);

        return $this->redirectWhen($accepted, $document->routes->show);
    }

    public function reject(Enterprise $enterprise, Document $document, Request $request)
    {
        $this->authorize('reject', $document);

        return view('addworking.enterprise.document.reject', @compact('document', 'enterprise'));
    }

    public function storeReject(Enterprise $enterprise, Document $document, StoreRejectDocumentRequest $request)
    {
        $rejected = $this->repository->rejectFromRequest($document, $request);

        UpdateContractStateByDocumentValidationJob::dispatchSync($document);

        return $this->redirectWhen($rejected, $document->routes->show);
    }

    public function tag(Enterprise $enterprise, Document $document, Request $request)
    {
        $document->tag($request->input('tag'));

        return back()->with(success_status(__('Tag ajouté')));
    }

    public function untag(Enterprise $enterprise, Document $document, Request $request)
    {
        $document->untag($request->input('tag'));

        return back()->with(success_status(__('Tag supprimé')));
    }

    public function download(Enterprise $enterprise, Document $document)
    {
        return response()->download($document->zip());
    }

    public function history(Enterprise $enterprise, DocumentType $document_type)
    {
        $this->authorize('showHistory', $document_type->documents->first());

        $items = Document::query()
            ->withTrashed()
            ->when(! Auth::user()->isSupport(), function ($query) use ($enterprise, $document_type) {
                return $query->ofStatuses([Document::STATUS_VALIDATED, Document::STATUS_OUTDATED]);
            })
            ->ofEnterprise($enterprise)
            ->ofDocumentType($document_type)
            ->latest()
            ->paginate();

        return view('addworking.enterprise.document.history', compact('enterprise', 'document_type', 'items'));
    }

    public function showTrashed(Enterprise $enterprise, $document)
    {
        $document = Document::onlyTrashed()->find($document);
        $this->authorize('show', $document);

        return view('addworking.enterprise.document.show', compact('document', 'enterprise'));
    }

    public function storePreCheck(Enterprise $enterprise, Document $document)
    {
        $updated = $document->update(['is_pre_check' => true]);

        return $this->redirectWhen($updated, $document->routes->show);
    }

    public function removePreCheck(Enterprise $enterprise, Document $document)
    {
        $updated = $document->update(['is_pre_check' => false]);

        return $this->redirectWhen($updated, $document->routes->show);
    }

    public function documentActionsHistory(Enterprise $enterprise, Document $document)
    {
        $items = $document->actions()->paginate();

        return view(
            'addworking.enterprise.document.actions_history',
            compact('document', 'enterprise', 'items')
        );
    }
}
