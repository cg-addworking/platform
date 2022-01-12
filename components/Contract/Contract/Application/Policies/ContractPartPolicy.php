<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPartPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $contractRepository;
    protected $contractStateRepository;
    protected $contractPartRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractRepository $contractRepository,
        ContractStateRepository $contractStateRepository,
        ContractPartRepository $contractPartRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->contractPartRepository = $contractPartRepository;
    }

    public function create(User $user, Contract $contract)
    {
        if ($this->contractStateRepository->toValidate($contract) ||
            $this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract)
        ) {
            return Response::deny("Contract state doesn't allow you to create a contract part.");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->contractRepository->isOwnerOf($user, $contract)) {
            return Response::deny('Connected user is not owner of this contract');
        }

        return Response::allow();
    }

    public function store(User $user, Contract $contract)
    {
        return $this->create($user, $contract);
    }

    public function createSignedContractPart(User $user, Contract $contract)
    {
        if (!($this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract))
        ) {
            return Response::deny("Contract is state won't allow you.");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$this->contractRepository->isPartyOf($user, $contract)
            && !$this->contractRepository->isOwnerOf($user, $contract)) {
            return Response::deny('Connected user is not owner of this contract');
        }

        return Response::allow();
    }

    public function storeSignedContractPart(User $user, Contract $contract)
    {
        return $this->createSignedContractPart($user, $contract);
    }

    public function delete(User $user, ContractPart $contract_part)
    {
        if ($this->contractPartRepository->hasContractModelPart($contract_part)) {
            return Response::deny('Contract Part created from a contract model cannot be deleted');
        }

        if ($contract_part->getIsUsedInContractBody()
            && $this->contractRepository->checkIfContractIsSigned($contract_part->getContract())) {
            return Response::deny('Contract Part that belongs to a signed contract cannot be deleted');
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (!$user->enterprises->contains($contract_part->getContract()->getEnterprise())) {
            return Response::deny('Logged in user is not member of the enterprise that owns the contract');
        }

        return Response::allow();
    }

    public function orderUp(User $user, ContractPart $contract_part)
    {
        if ($this->contractPartRepository->isOrderedFirst($contract_part, ContractPartEntityInterface::ORDER_UP)) {
            return Response::deny('this part is ordered first');
        }

        return Response::allow();
    }

    public function orderDown(User $user, ContractPart $contract_part)
    {
        if ($this->contractPartRepository->isOrderedLast($contract_part, ContractPartEntityInterface::ORDER_DOWN)) {
            return Response::deny('this part is ordered last');
        }

        return Response::allow();
    }

    public function regenerate(User $user, Contract $contract)
    {
        if ($this->contractStateRepository->toValidate($contract) ||
            $this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract)
        ) {
            return Response::deny("Contract state doesn't allow you to regenerate the contract.");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->contractRepository->isOwnerOf($user, $contract) &&
            !($contract->getContractModel()->getShouldVendorsFillTheirVariables() &&
                $this->contractRepository->isPartyOf($user, $contract))) {
            return Response::deny('Connected user is not allowed to regenerate contract.');
        }

        return Response::allow();
    }
}
