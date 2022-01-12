<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsForSogetrelJob;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsJob;
use Components\Contract\Contract\Application\Jobs\SendContractToYousignJob;
use Components\Contract\Contract\Application\Jobs\UploadSignedContractJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Requests\StoreContractRequest;
use Components\Contract\Contract\Application\Requests\StoreContractWithoutModelRequest;
use Components\Contract\Contract\Application\Requests\StoreContractWithoutModelToSignRequest;
use Components\Contract\Contract\Application\Requests\UpdateContractRequest;
use Components\Contract\Contract\Application\Requests\UploadSignedContractRequest;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\UseCases\ArchiveContract;
use Components\Contract\Contract\Domain\UseCases\AssociateMissionToContract;
use Components\Contract\Contract\Domain\UseCases\CallBackContract;
use Components\Contract\Contract\Domain\UseCases\CreateContract;
use Components\Contract\Contract\Domain\UseCases\CreateContractWithoutModel;
use Components\Contract\Contract\Domain\UseCases\CreateContractWithoutModelToSign;
use Components\Contract\Contract\Domain\UseCases\DeleteContract;
use Components\Contract\Contract\Domain\UseCases\DownloadContract;
use Components\Contract\Contract\Domain\UseCases\DownloadContractDocuments;
use Components\Contract\Contract\Domain\UseCases\EditContract;
use Components\Contract\Contract\Domain\UseCases\EditContractParty;
use Components\Contract\Contract\Domain\UseCases\ListContract;
use Components\Contract\Contract\Domain\UseCases\ListContractAsSupport;
use Components\Contract\Contract\Domain\UseCases\ListContractParty;
use Components\Contract\Contract\Domain\UseCases\SendNotificationToSignContract;
use Components\Contract\Contract\Domain\UseCases\ShowContract;
use Components\Contract\Contract\Domain\UseCases\UpdateContractFromYousignData;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Enterprise\Enterprise\Application\Jobs\SendContractCsvExportJob;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Components\Contract\Contract\Domain\UseCases\UnarchiveContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;

class ContractController extends Controller
{
    private $contractRepository;
    private $contractPartRepository;
    private $contractPartyRepository;
    private $enterpriseRepository;
    private $contractModelRepository;
    private $userRepository;
    private $contractStateRepository;
    private $contractVariableRepository;
    private $missionRepository;
    protected $exportRepository;

    public function __construct(
        ContractRepository $contractRepository,
        ContractPartRepository $contractPartRepository,
        ContractPartyRepository $contractPartyRepository,
        EnterpriseRepository $enterpriseRepository,
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository,
        ContractStateRepository $contractStateRepository,
        ContractVariableRepository $contractVariableRepository,
        MissionRepository $missionRepository,
        ExportRepository $exportRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->missionRepository = $missionRepository;
        $this->exportRepository = $exportRepository;
    }

    public function createSupport(Request $request)
    {
        $this->authorize('createSupport', Contract::class);

        $contract = $this->contractRepository->make();

        $enterprises_with_model = Enterprise::has('publishedContractModels')->orderBy('name')->cursor();

        $enterprise = Enterprise::find($request->input('enterprise')) ?? $enterprises_with_model->first();

        $contract_models = is_null($enterprise)
            ? []
            : $this->enterpriseRepository->getPublishedContractModels($enterprise)->pluck('display_name', 'id');

        $contract_model = $request->has('contract_model') ?
            $this->contractModelRepository->find($request->input('contract_model')) : null;

        $enterprises = !is_null($contract_model) ?
            $this->contractModelRepository->getEnterpriseAndChildren($contract_model)
                ->sortBy('name')
                ->pluck('name', 'id') : [];

        $mission = $this->getMission($request->input('mission'));

        $suggested_name = $this->getSuggestedName($mission);

        return view(
            'contract::contract.create',
            compact(
                'contract',
                'enterprises_with_model',
                'contract_models',
                'enterprises',
                'mission',
                'suggested_name'
            )
        );
    }

    public function create(Request $request)
    {
        $this->authorize('create', Contract::class);

        $contract = $this->contractRepository->make();

        $auth_user = $this->userRepository->connectedUser();

        $enterprises_with_model = $this->enterpriseRepository->getEterprisesAscendentWhereHasContractModels($auth_user);

        $enterprise = Enterprise::find($request->input('enterprise')) ?? $enterprises_with_model->first();

        $contract_models = is_null($enterprise)
            ? []
            : $this->enterpriseRepository->getPublishedContractModels($enterprise)->pluck('display_name', 'id');

        $enterprises = $this->enterpriseRepository->getUserEnterprises($auth_user)->pluck('name', 'id');

        $mission = $this->getMission($request->input('mission'));

        $suggested_name = $this->getSuggestedName($mission);

        return view(
            'contract::contract.create',
            compact(
                'contract',
                'enterprise',
                'enterprises_with_model',
                'contract_models',
                'enterprises',
                'mission',
                'suggested_name'
            )
        );
    }

    public function store(StoreContractRequest $request)
    {
        $this->authorize('create', Contract::class);

        $contract = App::make(CreateContract::class)->handle(
            $request->user(),
            $request->input('contract')
        );

        if ($request->input('mission')) {
            $input['mission']['id'] = $this->missionRepository->find($request->input('mission'))->id;
            App::make(AssociateMissionToContract::class)->handle(
                $request->user(),
                $contract,
                $input
            );
        }

        return $this->redirectWhen($contract->exists, route('contract.party.create', $contract));
    }

    public function index(Request $request)
    {
        $this->authorize('index', Contract::class);

        $user = $this->userRepository->connectedUser();

        $items = App::make(ListContract::class)
            ->handle(
                $user,
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field'),
            );

        $searchable_attributes = $this->contractRepository->getSearchableAttributes();

        $contract_models = $this->enterpriseRepository
            ->getPublishedContractModels($user->enterprise)->pluck('name', 'id');

        $users = $this->userRepository->getUsersOfEnterprisesOf($user)->pluck('name', 'id');

        $work_fields = $this->userRepository->getWorkFieldsWhichUserIsMember($user)
                            ->sortBy('display_name')->pluck('display_name', 'id');

        return view(
            'contract::contract.index',
            compact(
                'items',
                'user',
                'searchable_attributes',
                'contract_models',
                'users',
                'work_fields'
            )
        );
    }

    public function indexSupport(Request $request)
    {
        $this->authorize('indexSupport', Contract::class);

        $user = $this->userRepository->connectedUser();

        $items = App::make(ListContractAsSupport::class)
            ->handle(
                $user,
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field'),
            );

        $searchable_attributes = $this->contractRepository->getSearchableAttributes();

        $contract_models = $this->contractModelRepository->getAllPublishedContractModels()->pluck('name', 'id');

        $users = $this->userRepository->getAllUsersHasAccessToContract()->pluck('name', 'id');

        $work_fields = $this->contractRepository->getWorkFieldsAttachedToContract()
                        ->flatten()->unique('id')->sortBy('display_name')->pluck('display_name', 'id');

        $addworking_id = Enterprise::where('name', 'ADDWORKING')->first()->getId();

        return view(
            'contract::contract.support.index',
            compact(
                'items',
                'searchable_attributes',
                'contract_models',
                'users',
                'work_fields',
                'addworking_id'
            )
        );
    }

    public function indexSupportForEnterprise(Enterprise $enterprise, Request $request)
    {
        $this->authorize('indexSupport', Contract::class);

        $items = $this->contractRepository->listAsSupportForEnterprise(
            $enterprise,
            $request->input('filter'),
            $request->input('search'),
            $request->input('per-page')
        );
        $searchable_attributes = $this->contractRepository->getSearchableAttributes();

        $contract_models = $this->contractModelRepository->getAllPublishedContractModels()->pluck('name', 'id');

        $users = $this->userRepository->getAllUsersHasAccessToContract()->pluck('name', 'id');

        $work_fields = $this->contractRepository
            ->getWorkFieldsAttachedToContract()->flatten()->unique('id')->pluck('name', 'id');

        $addworking_id = Enterprise::where('name', 'ADDWORKING')->first()->getId();

        return view(
            'contract::contract.support.index',
            compact(
                'items',
                'searchable_attributes',
                'contract_models',
                'users',
                'work_fields',
                'addworking_id'
            )
        );
    }

    public function edit(Request $request, Contract $contract)
    {
        $this->authorize('edit', $contract);

        $enterprises = $this->enterpriseRepository->getEnterprisesWithContractPartnership($contract);

        $enterprise = Enterprise::find($request->input('enterprise')) ?? $contract->getEnterprise();

        $contract_models = $this->enterpriseRepository->getPublishedContractModels($enterprise);

        $enterprise = $contract->getEnterprise();

        return view('contract::contract.edit', compact('contract', 'enterprises', 'contract_models', 'enterprise'));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $this->authorize('edit', $contract);

        $contract = App::make(EditContract::class)->handle(
            $this->userRepository->connectedUser(),
            $contract,
            $request->input('contract')
        );
        
        if ($request->has('contract_party')) {
            $edit_party_results = [];
            foreach ($request->input('contract_party') as $contract_party_inputs) {
                $contract_party = $this->contractPartyRepository->find($contract_party_inputs['contract_party_id']);
                $edit_party_results[] = App::make(EditContractParty::class)->handle(
                    $this->userRepository->connectedUser(),
                    $contract_party,
                    $contract_party_inputs
                );
            }
        }

        $contract_parent = $contract->getParent();
        if (! is_null($contract_parent)) {
            $this->contractStateRepository->updateContractState($contract_parent);
        }
        if ($this->contractRepository->canBeRegenerated($contract)) {
            $this->contractVariableRepository->updateSystemContractVariables($contract);
            $contract->setState(ContractEntityInterface::STATUS_GENERATING);
            $this->contractRepository->save($contract);

            // todo: temporary solution to isolate generation of sogetrel contracts
            $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
            $sogetrelFamily = App::make(EnterpriseRepository::class)->getDescendants($sogetrel, true);

            if ($sogetrelFamily->contains($contract->getEnterprise())) {
                GenerateContractPartsForSogetrelJob::dispatch($request->user(), $contract);
            } else {
                GenerateContractPartsJob::dispatchSync($request->user(), $contract);
            }
        }

        return $request->has('contract_party') ?
            $this->redirectWhen(
                $contract->exists && !in_array(false, $edit_party_results),
                route('contract.show', $contract)
            ) :
            $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }

    public function delete(Contract $contract)
    {
        $this->authorize('delete', $contract);

        $deleted = App::make(DeleteContract::class)
            ->handle($this->userRepository->connectedUser(), $contract);
        $contract_parent = $contract->getParent();
        if (! is_null($contract_parent)) {
            $this->contractStateRepository->updateContractState($contract_parent);
        }

        if ($this->userRepository->connectedUser()->isSupport()) {
            return $this->redirectWhen($deleted, route('support.contract.index'));
        } else {
            return $this->redirectWhen($deleted, route('contract.index'));
        }
    }

    public function show(Contract $contract)
    {
        $this->authorize('show', $contract);

        $contract = App::make(ShowContract::class)
            ->handle($this->userRepository->connectedUser(), $contract);

        $contract_parties = App::make(ListContractParty::class)
            ->handle($this->userRepository->connectedUser(), $contract);

        $user = $this->userRepository->connectedUser();
        $logged_in_party = $this->contractPartyRepository->getPartyForContract($user, $contract);
        $logged_in_validator = $this->contractPartyRepository->getNextPartyValidatorForContract($user, $contract);

        //reordering the parts before showing them
        $this->contractRepository->orderContractParts($contract);

        $contract_parts = $this->contractRepository
            ->getContractParts($contract, true)
            ->sortBy('order');

        $non_body_contract_parts = $this
                ->contractRepository
                ->getNonBodyContractPart($contract)
                ->sortBy('order');

        $compliance_documents = [];

        foreach ($contract_parties as $contract_party) {
            if ($contract_model_party = $contract_party->getContractModelParty()) {
                $query = ContractModelDocumentType::whereHas(
                    'contractModelParty',
                    function ($query) use ($contract_model_party) {
                        return $query->where('id', $contract_model_party->getId());
                    }
                )->latest()->get();

                if (count($query)) {
                    $compliance_documents[$contract_party->getEnterprise()->id] = $query;
                }
            }
        }

        $validator_parties = $this->contractRepository->getValidatorParties($contract);

        $this->handleAlerts($user, $contract);

        $document_actions = $this->contractRepository->getContractDocumentActions($contract);

        return view(
            'contract::contract.show',
            compact(
                'contract',
                'contract_parties',
                'validator_parties',
                'logged_in_party',
                'logged_in_validator',
                'contract_parts',
                'non_body_contract_parts',
                'compliance_documents',
                'user',
                'document_actions'
            )
        );
    }

    private function handleAlerts($user, Contract $contract)
    {
        if ($contract->getState() === ContractEntityInterface::STATE_GENERATING) {
            $this->success(
                __('messages.contract.generating_alert'),
                [
                    'icon'  =>'sync',
                    'text'  =>__('components.contract.contract.application.views.contract._html.generating_refresh'),
                    'href'  => route('contract.show', $contract),
                ]
            );
        }

        if ($user->can('requestDocuments', $contract)) {
            $contract_party = $this->contractRepository->getPartiesWithoutOwner($contract)->first();
            $this->warning(
                __(
                    'messages.contract.request_documents',
                    [
                        'party_denomination' => $contract_party->getDenomination(),
                    ]
                ),
                [
                    'icon'  => 'envelope',
                    'text'  =>__(
                        'components.contract.contract.application.views.contract._html.request_documents',
                        [
                            'party_denomination' => $contract_party->getDenomination(),
                        ]
                    ),
                    'href'  => route('contract.send_request_document_notification', $contract),
                ]
            );
        }

        if ($contract->getState() === ContractEntityInterface::STATE_MISSING_DOCUMENTS
            && !is_null($contract->getYousignProcedureId())) {
            $this->warning(__('messages.contract.missing_document'));
        }
    }

    public function generate(Contract $contract)
    {
        $this->authorize('generate', $contract);

        $auth_user = $this->userRepository->connectedUser();

        $contract->setState(ContractEntityInterface::STATE_GENERATING);
        $this->contractRepository->save($contract);

        // todo: temporary solution to isolate generation of sogetrel contracts
        $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
        $sogetrelFamily = App::make(EnterpriseRepository::class)->getDescendants($sogetrel, true);

        if ($sogetrelFamily->contains($contract->getEnterprise())) {
            GenerateContractPartsForSogetrelJob::dispatch($auth_user, $contract);
        } else {
            GenerateContractPartsJob::dispatchSync($auth_user, $contract);
        }

        return $this->redirectWhen(
            true,
            route('contract.show', $contract)
        );
    }

    public function sendToSign(Contract $contract)
    {
        $first_contract_party = $this->contractPartyRepository->getContractPartyByOrderOf($contract, 1);

        $enterprise_language = $first_contract_party->getEnterprise()->getContractualizationLanguage() ?? 'fr';

        SendContractToYousignJob::dispatchSync($contract, $enterprise_language);

        $auth_user = $this->userRepository->connectedUser();
        $contract->setSentToSignatureBy($auth_user);
        $this->contractRepository->save($contract);

        $next_party_to_validate = $this->contractPartyRepository
            ->getNextPartyThatShouldValidate($contract);
        if (isset($next_party_to_validate)) {
            ActionTrackingHelper::track(
                $this->userRepository->connectedUser(),
                ActionEntityInterface::SEND_CONTRACT_TO_VALIDATION,
                $contract,
                __(
                    'components.contract.contract.application.tracking.send_contract_to_validation',
                    ['user' => $next_party_to_validate->signatory()->first()->name]
                )
            );
        } else {
            ActionTrackingHelper::track(
                $this->userRepository->connectedUser(),
                ActionEntityInterface::SEND_CONTRACT_TO_SIGNATURE,
                $contract,
                __('components.contract.contract.application.tracking.send_contract_to_signature')
            );
        }

        return redirect()->back();
    }

    public function uploadSignedContract(Request $request, Contract $contract)
    {
        $this->authorize('uploadSignedContract', $contract);
        
        $part = $this->contractPartRepository->make();

        $parties = $this->contractRepository->getSignatoryParties($contract);

        return view('contract::contract.upload_signed_contract', compact('contract', 'part', 'parties'));
    }

    public function saveUploadSignedContract(UploadSignedContractRequest $request, Contract $contract)
    {
        $this->authorize('saveUploadSignedContract', $contract);

        UploadSignedContractJob::dispatchSync(
            $this->contractRepository,
            $this->userRepository->connectedUser(),
            $contract,
            $request->input(),
            $this->contractPartRepository->createFile($request->file('contract_part.file'))
        );

        $this->contractStateRepository->updateContractState($contract);

        return $this->redirectWhen(true, route('contract.show', $contract), "Le contrat est en cours de génération.");
    }

    public function createContractWithoutModel(Request $request)
    {
        $this->authorize('createContractWithoutModel', Contract::class);

        $contract = $this->contractRepository->make();

        $auth_user = $this->userRepository->connectedUser();
        
        $mission = null;
        if ($request->has('mission')) {
            $mission = $this->missionRepository->find($request->input('mission'));
            $enterprises = $this->enterpriseRepository
                ->getAncestors($mission->customer, true)
                ->pluck('name', 'id');
        } else {
            $enterprises = ($this->userRepository->isSupport($auth_user)
            ? Enterprise::get()->sortBy('name')->pluck('name', 'id')
            : $this->userRepository->getEnterprisesOf($auth_user)->sortBy('name')->pluck('name', 'id'));
        }

        return view(
            'contract::contract.create_without_model',
            compact(
                'contract',
                'enterprises',
                'mission'
            )
        );
    }

    public function storeContractWithoutModel(StoreContractWithoutModelRequest $request)
    {
        $this->authorize('storeContractWithoutModel', Contract::class);
        
        $contract = App::make(CreateContractWithoutModel::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input(),
            $request->file('contract_part.file')
        );

        if ($request->input('mission')) {
            $inputs['mission']['id'] = $this->missionRepository->find($request->input('mission'))->id;
            App::make(AssociateMissionToContract::class)->handle(
                $request->user(),
                $contract,
                $inputs
            );
        }

        return $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }

    public function createContractWithoutModelToSign()
    {
        $this->authorize('createContractWithoutModelToSign', Contract::class);

        $contract = $this->contractRepository->make();

        $auth_user = $this->userRepository->connectedUser();
        
        $enterprises = ($this->userRepository->isSupport($auth_user)
            ? Enterprise::get()->sortBy('name')->pluck('name', 'id')
            : $this->userRepository->getEnterprisesOf($auth_user)->sortBy('name')->pluck('name', 'id'));

        return view('contract::contract.create_without_model_to_sign', compact('contract', 'enterprises'));
    }

    public function storeContractWithoutModelToSign(StoreContractWithoutModelToSignRequest $request)
    {
        $this->authorize('storeContractWithoutModelToSign', Contract::class);
        
        $contract = App::make(CreateContractWithoutModelToSign::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input(),
            $request->file('contract_part.file')
        );

        return $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }

    public function cancel(Contract $contract)
    {
        $this->authorize('cancel', $contract);
        $contract->setState(ContractEntityInterface::STATE_CANCELED);
        $contract->setCanceledAt(Carbon::now());

        $saved = $this->contractRepository->save($contract);

        return $this->redirectWhen($saved, route('contract.show', $contract));
    }

    public function deactivate(Contract $contract)
    {
        $this->authorize('deactivate', $contract);

        $contract->setState(ContractEntityInterface::STATE_INACTIVE);
        $contract->setInactiveAt(Carbon::now());

        $saved = $this->contractRepository->save($contract);

        return $this->redirectWhen($saved, route('contract.show', $contract));
    }

    public function sign(Contract $contract, ContractParty $party)
    {
        $redirection = $this->getUserRedirectionWhenSigning($contract, $party);
        if (!is_null($redirection)) {
            return $redirection;
        }

        $this->authorize('sign', $contract);

        $client = new Yousign;

        $first_contract_party = $this->contractPartyRepository->getContractPartyByOrderOf($contract, 1);

        $enterprise_language = $first_contract_party->getEnterprise()->getContractualizationLanguage() ?? 'fr';

        $signatureUi = $client->getSignIframeUri($party->getYousignMemberId(), $enterprise_language);

        return view('contract::contract.sign', compact('contract', 'signatureUi'));
    }

    public function validateContract(Contract $contract, ContractParty $party)
    {
        $this->authorize('validate', [$contract, $party]);

        $client = new Yousign;

        $first_contract_party = $this->contractPartyRepository->getContractPartyByOrderOf($contract, 1);

        $enterprise_language = $first_contract_party->getEnterprise()->getContractualizationLanguage() ?? 'fr';

        $signatureUi = $client->getValidateIframeUri($party->getYousignMemberId(), $enterprise_language);

        return view('contract::contract.sign', compact('contract', 'signatureUi'));
    }

    public function callBackContract(Contract $contract)
    {
        $this->authorize('callBackContract', $contract);
        
        $procedure_id = $contract->getYousignProcedureId();

        $calledBack = App::make(CallBackContract::class)->handle(
            $this->userRepository->connectedUser(),
            $contract
        );

        if ($calledBack) {
            $client = new Yousign;
            $client->delete($procedure_id);

            ActionTrackingHelper::track(
                $this->userRepository->connectedUser(),
                ActionEntityInterface::CONTRACT_CALLBACK,
                $contract,
                __(
                    'components.contract.contract.application.tracking.contract_callback',
                    ['date' => Carbon::now()->format('d-m-Y H:i:s')]
                )
            );
        }

        return $this->redirectWhen($calledBack, route('contract.show', $contract));
    }

    protected function getUserRedirectionWhenSigning(Contract $contract, ContractParty $party)
    {
        $auth_user = $this->userRepository->connectedUser();
        if (!$this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract)) {
            if ($this->contractRepository->canSign($contract, $auth_user) &&
                !$this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidatedForParty($contract, $party)
            ) {
                return redirect()->route('contract.party.document.index', [$contract, $party])->with(
                    info_status(
                        __('addworking.enterprise.document_type.index.missing_documents_before_sign_contract')
                    )
                );
            } else {
                return redirect()->route('contract.show', $contract);
            }
        }
        return null;
    }

    /**
     * @todo refactor this
     */
    public function callbackMemberFinished(Request $request)
    {
        $this->webhookFunction($request);
    }

    /**
     * @todo refactor this
     */
    public function callbackProcedureRefused(Request $request)
    {
        $this->webhookFunction($request);
    }

    /**
     * @todo refactor this
     */
    public function callbackProcedureFinished(Request $request)
    {
        $this->webhookFunction($request);
    }

    /**
     * @todo refactor this
     */
    public function webhook(Request $request)
    {
        $this->webhookFunction($request);
    }

    /**
     * @todo refactor this
     */
    private function webhookFunction($request)
    {
        try {
            $data = $request->all();
            $contract = $this->contractRepository->findByYousignProcedureId("/procedures/".$data['procedure']['id']);

            $contract->setNextPartyToSign(null);
            $contract->setNextPartyToValidate(null);
            $this->contractRepository->save($contract);

            if (in_array($data['eventName'], ["member.finished", "procedure.refused"])) {
                /* @var ContractParty $contract_party */
                $contract_party = ContractParty::wherehas('contract', function ($query) use ($data) {
                    return $query->where('yousign_procedure_id', "/procedures/".$data['procedure']['id']);
                })->where('yousign_member_id', "/members/".$data['member']['id'])
                    ->first();
                switch ($data['eventName']) {
                    case "member.finished":
                        if ($contract->getState() === ContractEntityInterface::STATE_TO_VALIDATE
                            && $contract_party->getIsValidator()) {
                            $attribute = "validated_at";
                            ActionTrackingHelper::track(
                                $contract_party->getSignatory(),
                                ActionEntityInterface::PARTY_VALIDATES_CONTRACT,
                                $contract,
                                __('components.contract.contract.application.tracking.party_validates_contract')
                            );
                        } else {
                            if ($contract->getState() === ContractEntityInterface::STATE_TO_SIGN) {
                                $attribute = "signed_at";
                                $client = new Yousign;
                                foreach ($contract->getParts() as $part) {
                                    if (! is_null($part->getYousignFileId())) {
                                        $content = $client->downloadFile($part->getYousignFileId());
                                        $file =
                                            $this->contractPartRepository->createFile(base64_decode($content->body));
                                        $part->setFile($file);
                                        $this->contractPartRepository->save($part);
                                    }
                                }
                                if (is_null($contract_party->getSignedAt())) {
                                    ActionTrackingHelper::track(
                                        $contract_party->getSignatory(),
                                        ActionEntityInterface::PARTY_SIGNS_CONTRACT,
                                        $contract,
                                        __('components.contract.contract.application.tracking.party_signs_contract')
                                    );
                                }
                            }
                        }
                        break;
                    case "procedure.refused":
                        $attribute = "declined_at";
                        $content = $data['member']['comment'];
                        $author = ContractParty::where('yousign_member_id', "/members/".$data['member']['id'])
                            ->first()->getSignatory();
                        if (!is_null($content)) {
                            $visibility = Comment::VISIBILITY_PUBLIC;
                            $comment = new Comment(@compact('content', 'visibility'));
                            $comment->commentable()->associate($contract);
                            $comment->author()->associate($author);
                            $comment->save();
                        }

                        if (! is_null($contract->getCreatedBy())
                            && !$contract_party->getSignatory()->is($contract->getCreatedBy())) {
                            $this->contractRepository->sendNotificationForRefusedContract(
                                $contract,
                                $contract->getCreatedBy()
                            );
                        }

                        ActionTrackingHelper::track(
                            $author,
                            ActionEntityInterface::PARTY_REFUSES_TO_SIGN_CONTRACT,
                            $contract,
                            __('components.contract.contract.application.tracking.party_refuses_to_sign_contract')
                        );
                        break;
                }

                if (isset($attribute)) {
                    $contract_party->update([
                        $attribute => Carbon::parse($data['member']['updatedAt'])->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            if ($data['eventName'] == "procedure.finished" && is_null($contract->getValidFrom())) {
                $contract->setValidFrom(Carbon::now());
                $this->contractRepository->save($contract);
            }

            $this->contractStateRepository->updateContractState($contract);

            if (in_array(
                $contract->getState(),
                [ContractEntityInterface::STATE_ACTIVE, ContractEntityInterface::STATE_SIGNED]
            ) && $data['eventName'] == "member.finished"
            ) {
                if (! is_null($contract->getCreatedBy())) {
                    $this->contractRepository->sendNotificationForSignedContract(
                        $contract,
                        $contract->getCreatedBy()
                    );
                }

                if (! is_null($contract->getSentToSignatureBy())) {
                    if (! is_null($contract->getCreatedBy())
                        && $contract->getCreatedBy()->getId() !== $contract->getSentToSignatureBy()->getId()
                    ) {
                        $this->contractRepository->sendNotificationForSignedContract(
                            $contract,
                            $contract->getSentToSignatureBy()
                        );
                    } else {
                        $this->contractRepository->sendNotificationForSignedContract(
                            $contract,
                            $contract->getSentToSignatureBy()
                        );
                    }
                }

                $validator_parties = $this->contractRepository->getValidatorParties($contract);
                if (! is_null($validator_parties)) {
                    foreach ($validator_parties as $validator_partie) {
                        if ($validator_partie->getSignatory()->getId() !== $contract->getCreatedBy()->getId() &&
                            $validator_partie->getSignatory()->getId() !== $contract->getSentToSignatureBy()->getId()) {
                            $this->contractRepository->sendNotificationForSignedContract(
                                $contract,
                                $validator_partie->getSignatory()
                            );
                        }
                    }
                }
            }

            if ($data['eventName'] == "member.finished") {
                $next_party_to_validate = $this->contractPartyRepository
                    ->getNextPartyThatShouldValidate($contract);
                if (isset($next_party_to_validate)) {
                    $contract->setNextPartyToValidate($next_party_to_validate);
                    $this->contractRepository->sendNotificationToValidateContractOnYousign(
                        $contract,
                        $next_party_to_validate,
                        false
                    );
                } else {
                    $next_party_to_sign = $this->contractPartyRepository->getNextPartyThatShouldSign($contract);
                    if (isset($next_party_to_sign)) {
                        $contract->setNextPartyToSign($next_party_to_sign);
                        App::make(SendNotificationToSignContract::class)
                            ->handle(
                                null,
                                $contract,
                                $next_party_to_sign,
                                false
                            );
                    }
                }
                $this->contractRepository->save($contract);
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    protected function getMission(?string $mission_id)
    {
        if (is_null($mission_id)) {
            return null;
        }

        return $this->missionRepository->find($mission_id);
    }

    protected function getSuggestedName($mission)
    {
        if (is_null($mission)) {
            return null;
        }

        $vendor_name = $mission->vendor->name;

        if ($mission->getWorkField()) {
            $external_id = $mission->getWorkField()->getExternalId();

            return "Contrat avec {$vendor_name} pour le chantier {$external_id}";
        }

        return "Contract avec {$vendor_name}";
    }

    public function download(Contract $contract)
    {
        $this->authorize('download', $contract);

        return App::make(DownloadContract::class)->handle(
            $this->userRepository->connectedUser(),
            $contract
        );
    }

    public function export(Request $request)
    {
        $this->authorize('export', Contract::class);
        $user = $this->userRepository->connectedUser();

        $export = $this->exportRepository->create(
            $request->user(),
            "export_contracts_".$request->user()->enterprise->name
                        ."_".Carbon::now()->format('Ymd_His'),
            $request->input('filter') ?? []
        );

        $contracts = $this->userRepository->isSupport($user) ?
            $this->contractRepository->listAsSupport(
                $user,
                $request->input('filter'),
                $request->input('search'),
                -1,
                $request->input('operator'),
                $request->input('field'),
            ) :
            $this->contractRepository->list(
                $user,
                $request->input('filter'),
                $request->input('search'),
                -1,
                $request->input('operator'),
                $request->input('field'),
            )
        ;

        SendContractCsvExportJob::dispatch(
            $user,
            $export,
            $user->enterprise,
            new Collection($contracts->items())
        );

        return redirect()->back()->with(success_status(
            __('components.contract.contract.application.views.contract.export.success')
        ));
    }

    public function archive(Contract $contract)
    {
        $this->authorize('archive', $contract);

        $auth_user = $this->userRepository->connectedUser();

        $archived_contract = App::make(ArchiveContract::class)
            ->handle($auth_user, $contract);

        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CONTRACT_ARCHIVED,
            $contract,
            __('components.contract.contract.application.tracking.contract_archived')
        );

        return $this->redirectWhen(
            $archived_contract->exists,
            route('contract.show', $archived_contract)
        );
    }

    public function unarchive(Contract $contract)
    {
        $this->authorize('unarchive', $contract);

        $auth_user = $this->userRepository->connectedUser();

        $unarchived_contract = App::make(UnarchiveContract::class)
            ->handle($auth_user, $contract);

        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CONTRACT_UNARCHIVED,
            $contract,
            __('components.contract.contract.application.tracking.contract_unarchived')
        );

        return $this->redirectWhen(
            $unarchived_contract->exists,
            route('contract.show', $unarchived_contract)
        );
    }

    public function downloadDocuments(Contract $contract)
    {
        $this->authorize('download', $contract);

        return App::make(DownloadContractDocuments::class)->handle(
            $this->userRepository->connectedUser(),
            $contract
        );
    }

    /**
     * @param Contract $contract
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function downloadProofOfSignature(Contract $contract)
    {
        $this->authorize('downloadProofOfSignature', $contract);

        return $this->contractRepository->downloadProofOfSignatureZip($contract);
    }

    public function updateContractFromYousignData(Contract $contract)
    {
        $this->authorize('updateContractFromYousignData', $contract);

        App::make(UpdateContractFromYousignData::class)->handle(
            $this->userRepository->connectedUser(),
            $contract
        );

        $this->contractStateRepository->updateContractState($contract);

        return redirect()->back();
    }
}
