<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\ContractNotificationRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\SectorRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class ContractPolicy
{
    use HandlesAuthorization;

    private $contractRepository;
    private $userRepository;
    private $contractVariableRepository;
    private $contractPartyRepository;
    private $contractNotificationRepository;
    private $contractStateRepository;

    public function __construct(
        ContractRepository $contractRepository,
        UserRepository $userRepository,
        ContractVariableRepository $contractVariableRepository,
        ContractPartyRepository $contractPartyRepository,
        ContractNotificationRepository $contractNotificationRepository,
        ContractStateRepository $contractStateRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function createSupport(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return $this->create($user);
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (!$user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! App::make(EnterpriseRepository::class)->hasContractModels($user->enterprise)) {
            return Response::deny("You don't have contract model");
        }
        
        return Response::allow();
    }

    public function index(User $user)
    {
        if ($this->userRepository->isSupport($this->userRepository->connectedUser())) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_READONLY)) {
            return Response::deny("You don't have a role for read this informations");
        }

        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function indexSupport(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function edit(User $user, Contract $contract)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises()->get()->contains($contract->getEnterprise())
            && ! $this->canAccessToContractWithWorkfield($user, $contract)
        ) {
            return Response::deny("You do not have access to this contract!!");
        }

        return Response::allow();
    }

    public function delete(User $user, Contract $contract)
    {
        if (in_array($contract->getState(), [
            ContractEntityInterface::STATE_TO_SIGN,
            ContractEntityInterface::STATE_SIGNED,
            ContractEntityInterface::STATE_TO_VALIDATE
        ])) {
            return Response::deny('This contract cannot be deleted !');
        }

        if (! $this->userRepository->isSupport($user)
            && $contract->getStatus() === ContractEntityInterface::STATE_ACTIVE) {
            return Response::deny('You do not have access to delete this contract!');
        }

        if ($this->userRepository->isSupport($user) ||
            ($user->enterprises()->get()->contains($contract->getEnterprise()) && $user->is($contract->getCreatedBy()))
        ) {
            return Response::allow();
        }

        return Response::deny('You do not have access to delete this contract!');
    }

    public function show(User $user, Contract $contract)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $user->enterprises()->get()->contains($contract->getEnterprise()) &&
            ! $this->contractRepository->isPartyOf($user, $contract) &&
            ! $this->canAccessToContractWithWorkfield($user, $contract)
        ) {
            return Response::deny('You do not have access to this contract!');
        }

        return Response::allow();
    }

    private function canAccessToContractWithWorkfield(User $user, Contract $contract)
    {
        $workfields = [];

        if (App::make(SectorRepository::class)->entreprisesBelongsToConstructionSector($user->enterprises)) {
            $workfields = WorkField::whereHas('workFieldContributors', function ($query) use ($user) {
                return $query->whereHas('contributor', function ($query) use ($user) {
                    return $query->where('id', $user->id);
                });
            })->get();
        }

        if (count($workfields) && $workfields->contains($contract->getWorkfield())) {
            return true;
        }

        return false;
    }

    public function requestValidation(User $user, Contract $contract)
    {
        if (!$this->contractStateRepository->generated($contract)) {
            return Response::deny("this contract can't be sent to signature!");
        }

        if (!count($this->userRepository->getUsersAllowedToSendContractToSignature($contract))) {
            return Response::deny("No user in the company has access to this feature.");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            return Response::deny('You do not have access to this contract!');
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_SEND_CONTRACT_TO_SIGNATURE)) {
            return Response::deny("You can't ask for generation if you are allowed to generate yourself.");
        }

        if (! $this->contractRepository->getValidatorParties($contract)->isEmpty()) {
            return Response::deny("this contract has validators");
        }

        return Response::allow();
    }

    public function uploadSignedContract(User $user, Contract $contract)
    {
        // TODO: Solution temporaire a remettre une fois Yousign ACTIF v0.76.7
        /*
        if (! in_array($contract->getState(), [
            ContractEntityInterface::STATE_TO_SIGN,
            ContractEntityInterface::STATE_SIGNED,
        ])
        ) {
            return Response::deny("The contract can not be uploaded");
        }
        */
        if (in_array($contract->getState(), [
            ContractEntityInterface::STATE_ACTIVE,
            ContractEntityInterface::STATE_SIGNED,
            ContractEntityInterface::STATE_DUE,
            ContractEntityInterface::STATE_CANCELED,
            ContractEntityInterface::STATE_DECLINED,
            ContractEntityInterface::STATE_MISSING_DOCUMENTS,
            ContractEntityInterface::STATE_IN_PREPARATION,
            ContractEntityInterface::STATE_TO_VALIDATE
        ])
        ) {
            return Response::deny("The contract can not be uploaded");
        }

        if (!$this->userRepository->isSupport($user)) {
            return Response::deny('User is not support');
        }

        if (!count($this->contractRepository->getContractParts($contract))) {
            return Response::deny('Contract must be generated before');
        }

        return Response::allow();
    }

    public function saveUploadSignedContract(User $user, Contract $contract)
    {
        return $this->uploadSignedContract($user, $contract);
    }

    public function createAmendment(User $user, Contract $contract)
    {
        if ($this->contractRepository->isAmendment($contract)) {
            return Response::deny('An amendment can\'t be created from another amendment.');
        }

        if (!($this->contractStateRepository->isActive($contract)
            || $this->contractStateRepository->isDue($contract)
            || $this->contractStateRepository->isSigned($contract))
        ) {
            return Response::deny("This contract can't have an amendment");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::deny("Enterprise is not owner of contract");
        }

        return $this->create($user);
    }

    public function createContractWithoutModel(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (!$user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function storeContractWithoutModel(User $user)
    {
        return $this->createContractWithoutModel($user);
    }

    public function cancel(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny('User is not support');
        }

        return Response::allow();
    }

    public function deactivate(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny('User is not support');
        }

        return Response::allow();
    }

    public function sign(User $user, Contract $contract)
    {
        if (! env('YOUSIGN_CONTRACT_ENABLED')) {
            Response::deny("you can't sign the contract {$contract->getId()}, Yousign is disabled");
        }

        if ($this->contractStateRepository->toSign($contract) && $this->contractRepository->canSign($contract, $user)) {
            return Response::allow();
        }

        return Response::deny('User cannot sign this contract');
    }

    public function validate(User $user, Contract $contract, ?ContractParty $party)
    {
        if (! env('YOUSIGN_CONTRACT_ENABLED')) {
            Response::deny("you can't sign the contract {$contract->getId()}, Yousign is disabled");
        }

        if ($this->contractStateRepository->toValidate($contract)
            && $this->contractRepository->canValidate($contract, $user, $party)) {
            return Response::allow();
        }

        return Response::deny('User cannot validate this contract');
    }

    public function createContractWithoutModelToSign(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (!$user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function storeContractWithoutModelToSign(User $user)
    {
        return $this->createContractWithoutModelToSign($user);
    }

    public function createAmendmentWithoutModelToSign(User $user, Contract $contract_parent)
    {
        if ($this->contractRepository->isAmendment($contract_parent)) {
            return Response::deny('You can\'t create an amendment from an amendment.');
        }

        if (!($this->contractStateRepository->isActive($contract_parent)
            || $this->contractStateRepository->isDue($contract_parent)
            || $this->contractStateRepository->isSigned($contract_parent))
        ) {
            return Response::deny("This contract can't have an amendment");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises()->get()->contains($contract_parent->getEnterprise())) {
            return Response::deny("Enterprise is not owner of contract");
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (!$user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function storeAmendmentWithoutModelToSign(User $user, Contract $contract_parent)
    {
        return $this->createAmendmentWithoutModelToSign($user, $contract_parent);
    }

    public function createAmendmentWithoutModel(User $user, Contract $contract_parent)
    {
        if ($this->contractRepository->isAmendment($contract_parent)) {
            return Response::deny('You can\'t create an amendment from an amendment.');
        }

        if (!($this->contractStateRepository->isActive($contract_parent)
            || $this->contractStateRepository->isDue($contract_parent)
            || $this->contractStateRepository->isSigned($contract_parent))
        ) {
            return Response::deny("This contract can't have an amendment");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises()->get()->contains($contract_parent->getEnterprise())) {
            return Response::deny("Enterprise is not owner of contract");
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (!$user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function storeAmendmentWithoutModel(User $user, Contract $contract_parent)
    {
        return $this->createAmendmentWithoutModel($user, $contract_parent);
    }

    public function orderParts(User $user, Contract $contract)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::deny("Enterprise is not owner of contract");
        }

        return Response::allow();
    }

    public function sendToSign(User $user, Contract $contract)
    {
        if ($contract->getState() !== ContractEntityInterface::STATE_GENERATED) {
            return Response::deny("this contract can't be sent to sign");
        }

        if (! $this->contractRepository->getValidatorParties($contract)->isEmpty()) {
            return Response::deny("this contract has validators ");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_SEND_CONTRACT_TO_SIGNATURE)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if ($user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this contract!');
    }

    public function requestSignature(User $user, Contract $contract)
    {
        if ($contract->getState() !== ContractEntityInterface::STATE_TO_SIGN) {
            return Response::deny("This contract is not to sign");
        }

        $next_party_to_sign = $this->contractPartyRepository->getNextPartyThatShouldSign($contract);
        if (is_null($next_party_to_sign)) {
            return Response::deny("This contract has no party that needs to sign");
        }

        if ($user->is($next_party_to_sign->getSignatory())) {
            return Response::deny("You can't send notifications to yourself");
        }

        return Response::allow();
    }

    public function requestDocuments(User $user, Contract $contract)
    {
        if (!in_array(
            $contract->getState(),
            [
                ContractEntityInterface::STATE_IN_PREPARATION,
                ContractEntityInterface::STATE_MISSING_DOCUMENTS,
                ContractEntityInterface::STATE_TO_VALIDATE,
                ContractEntityInterface::STATE_TO_SIGN,
            ]
        )
        ) {
            return Response::deny("This contract is not to complete");
        }

        $contract_party = $this->contractRepository->getPartiesWithoutOwner($contract)->first();
        if (! $this->contractRepository->checkIfSendNotificationDocumentsToParty(
            $contract,
            $contract_party
        )) {
            return Response::deny("All documents are ok.");
        }

        if ($this->contractNotificationRepository->exists(
            $contract,
            $contract_party->getSignatory(),
            ContractNotificationEntityInterface::REQUEST_DOCUMENTS,
            Carbon::now()->subHours(8)->toDate()
        )) {
            return Response::deny("Notification was already sent.");
        }

        if ($user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::allow();
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        return Response::deny("Can't request documents");
    }

    public function createSpecificDocument(User $user, Enterprise $enterprise, ?Document $document)
    {
        if (! is_null($document)) {
            return Response::deny("Document already exists");
        }

        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
            && $user->enterprise->is($enterprise));
    }

    public function linkContractToMission(User $user, Contract $contract)
    {
        if ($contract->getMission()) {
            return Response::deny('Contract is already assigned to a mission');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (! $user->enterprise->is($contract->getEnterprise())) {
            return Response::deny('You do not have access to this contract!');
        }

        return Response::allow();
    }

    public function sendToManager(User $user, Contract $contract)
    {
        if (!$this->contractStateRepository->generated($contract)) {
            return Response::deny("this contract can't be sent to signature!");
        }

        if (!count($this->userRepository->getUsersAllowedToSendContractToSignature($contract))) {
            return Response::deny("No user in the company has access to this feature.");
        }

        if (! $this->contractPartyRepository->checkIfCurrentUserCanSendTheContractToManger($user, $contract)) {
            return Response::deny("you can't access to this operation!");
        }

        if ($this->contractRepository->getValidatorParties($contract)->isEmpty()) {
            return Response::deny("There is no validator.");
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            return Response::deny('You do not have access to this contract!');
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_SEND_CONTRACT_TO_SIGNATURE) &&
             ! $this->contractRepository->getValidatorParties($contract)->isEmpty()) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this contract!');
    }

    public function requestValidationAndSendToSign(User $user, Contract $contract)
    {
        if ($contract->getState() !== ContractEntityInterface::STATE_GENERATED) {
            return Response::deny("this contract can't be sent to sign");
        }

        if (! $user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::deny('You do not have access to this contract!');
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_SEND_CONTRACT_TO_SIGNATURE) &&
             ! $this->contractRepository->getValidatorParties($contract)->isEmpty()) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this contract!');
    }

    public function callBackContract(User $user, Contract $contract)
    {
        return !is_null($contract->getCreatedBy())
            && ! is_null($contract->getYousignProcedureId())
            && in_array(
                $contract->getState(),
                [
                    ContractEntityInterface::STATE_TO_VALIDATE,
                    ContractEntityInterface::STATE_TO_SIGN,
                    ContractEntityInterface::STATE_DECLINED
                ]
            )
            && ($contract->getCreatedBy()->is($user)
                || $user->isSupport()
                || $this->contractRepository->isValidatorOf($user, $contract)
                || $this->contractRepository->checkIfUserCanCallBackContract($user, $contract)
                || $this->canAccessToContractWithWorkfield($user, $contract)
            );
    }

    public function download(User $user, Contract $contract)
    {
        if (! $contract->getParts()->count()) {
            return Response::deny('This contract has no part');
        }

        if ($contract->getState() == ContractEntityInterface::STATE_DRAFT) {
            return Response::deny('You do not need to download a draft contract');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if ($user->enterprises()->get()->contains($contract->getEnterprise()) ||
            $this->contractRepository->isPartyOf($user, $contract)
        ) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this contract!');
    }

    public function downloadProofOfSignature(User $user, Contract $contract)
    {
        if (!in_array($contract->getState(), [
            ContractEntityInterface::STATE_SIGNED,
            ContractEntityInterface::STATE_ACTIVE,
            ContractEntityInterface::STATE_DUE,
        ]) || $contract->getYousignProcedureId() === null) {
            return Response::deny("Proof of signature can't be downloaded on this contract.");
        }

        return Response::allow();
    }

    public function export(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return $this->index($user);
    }

    public function requestContractVariableValue(User $user, Contract $contract)
    {
        if (!$user->isSupport()) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function archive(User $user, Contract $contract)
    {
        return ($user->isSupport()
            || $user->enterprises()->get()->contains($contract->getEnterprise()))
            && is_null($contract->getArchivedAt());
    }

    public function unarchive(User $user, Contract $contract)
    {
        return ($user->isSupport()
            || $user->enterprises()->get()->contains($contract->getEnterprise()))
            && ! is_null($contract->getArchivedAt())
            && Carbon::now() <= $contract->getArchivedAt()->addDay();
    }

    public function indexAccountingMonitoring(User $user)
    {
        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_ACCOUNTING_MONITORING)) {
            return Response::deny("You don't have a role for read this informations");
        }

        return Response::allow();
    }

    public function updateContractFromYousignData(User $user, Contract $contract)
    {
        if (!in_array($contract->getState(), [
            ContractEntityInterface::STATE_DUE,
            ContractEntityInterface::STATE_SIGNED,
            ContractEntityInterface::STATE_TO_SIGN,
            ContractEntityInterface::STATE_TO_VALIDATE,
            ContractEntityInterface::STATE_ACTIVE,
        ])) {
            return Response::deny("Contract state won't allow you.");
        }

        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function editExternalIdentifier(User $user, Contract $contract)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! in_array($contract->getState(), [
            ContractEntityInterface::STATE_DRAFT,
            ContractEntityInterface::STATE_IN_PREPARATION,
            ContractEntityInterface::STATE_MISSING_DOCUMENTS,
            ContractEntityInterface::STATE_GENERATED,
        ])) {
            return Response::deny("Contract state won't allow you.");
        }

        if (!$user->enterprises()->get()->contains($contract->getEnterprise())) {
            return Response::deny("You do not have access to this contract!!");
        }

        return Response::allow();
    }
}
