<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractPartNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteContractPart
{
    private $contractPartRepository;
    private $userRepository;

    public function __construct(
        ContractPartRepositoryInterface $contractPartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractPartRepository = $contractPartRepository;
        $this->userRepository = $userRepository;
    }
    
    public function handle(
        User $auth_user,
        ?ContractPartEntityInterface $contract_part
    ) {
        $this->checkContractPart($contract_part);
        $this->checkUser($auth_user, $contract_part->getContract());

        return $this->contractPartRepository->delete($contract_part);
    }

    private function checkUser($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if ($this->userRepository->isSupport($user)) {
            return true;
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            throw new UserIsNotMemberOfTheContractEnterpriseException();
        }

        return true;
    }

    private function checkContractPart($contract_part)
    {
        if (is_null($contract_part)) {
            throw new ContractPartNotExistsException();
        }
    }
}
