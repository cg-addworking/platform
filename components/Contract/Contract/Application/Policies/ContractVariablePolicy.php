<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractVariablePolicy
{
    use HandlesAuthorization;

    private $userRepository;
    private $contractVariableRepository;
    private $contractRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractRepository $contractRepository,
        ContractVariableRepository $contractVariableRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractVariableRepository = $contractVariableRepository;
    }

    public function index(User $user, Contract $contract)
    {
        if (!$contract->getContractModel()) {
            return Response::deny('Without contract model no variable ');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->contractRepository->isPartyOf($user, $contract)) {
            return Response::deny('You do not have access to this contract!');
        }

        return Response::allow();
    }

    public function edit(User $user, Contract $contract)
    {
        if (!in_array($contract->getState(), [
            ContractEntityInterface::STATE_IN_PREPARATION,
            ContractEntityInterface::STATE_MISSING_DOCUMENTS,
            ContractEntityInterface::STATE_IS_READY_TO_GENERATE,
            ContractEntityInterface::STATE_GENERATING,
            ContractEntityInterface::STATE_GENERATED,
            ContractEntityInterface::STATE_UNKNOWN])) {
            return Response::deny('The contract is already signed');
        }
        
        if (!$this->contractVariableRepository->getUserFillableContractVariable($contract, $user)->count()) {
            return Response::deny('The contract has no variable to edit.');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $user->enterprises->contains($contract->getEnterprise()) &&
            ! $this->contractRepository->isCreator($user, $contract) &&
            ! $this->contractRepository->isPartyOf($user, $contract) &&
            ! $this->contractRepository->isValidatorOf($user, $contract)) {
            return Response::deny('You do not have access to the contract variables.');
        }

        return Response::allow();
    }
}
