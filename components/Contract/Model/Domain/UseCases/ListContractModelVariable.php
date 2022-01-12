<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListContractModelVariable
{
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelVariableRepositoryInterface $contractModelVariableRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        User $auth_user,
        ContractModelEntityInterface $contract_model,
        ?array $filter = null,
        ?array $search = null
    ) {
        $this->checkUser($auth_user);
        return $this->contractModelVariableRepository->list($contract_model, $filter, $search);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }
}
