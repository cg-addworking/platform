<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPartyPolicy
{
    use HandlesAuthorization;

    private $userRepository;
    private $contractRepository;

    public function __construct(UserRepository $userRepository, ContractRepository $contractRepository)
    {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
    }

    public function create(User $user, Contract $contract)
    {
        if ($this->contractRepository->getSignatoryParties($contract)->count()) {
            return Response::deny('contract has parties');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            return Response::deny('you do not have access to this contract!');
        }

        return Response::allow();
    }

    public function indexDocument(User $user, ContractParty $contract_party)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $user->enterprises->contains($contract_party->getEnterprise())) {
            return Response::deny('you do not have access to the party documents!');
        }

        return Response::allow();
    }

    public function uploadDocumentsNBA(User $user, ContractParty $contract_party)
    {
        if (!$contract_party->getContractModelParty()) {
            return Response::deny('You can\'t upload documents for a contract without contract model');
        }

        $needs_to_upload_documents = !$this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidatedForParty(
            $contract_party->getContract(),
            $contract_party
        );

        if (!$needs_to_upload_documents) {
            return Response::deny('There is no document to upload');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if ($user->enterprises->contains($contract_party->getEnterprise())) {
            return Response::allow();
        }
        
        return Response::deny('You do not have access to the party documents!');
    }

    /**
     * @param User $user
     * @param Contract $contract
     * @return bool
     */
    public function editValidators(User $user, Contract $contract)
    {
        return ($this->userRepository->isSupport($user) || $this->contractRepository->isCreator($user, $contract))
            && in_array($contract->getState(), [
                ContractEntityInterface::STATE_MISSING_DOCUMENTS,
                ContractEntityInterface::STATE_IN_PREPARATION,
                ContractEntityInterface::STATE_DRAFT,
                ContractEntityInterface::STATE_GENERATED
            ]);
    }
}
