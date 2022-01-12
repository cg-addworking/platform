<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListContractVariable
{
    private $contractVariableRepository;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractVariableRepositoryInterface $contractVariableRepository
    ) {
        $this->contractVariableRepository = $contractVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        User $auth_user,
        ContractEntityInterface $contract,
        ?array $filter = null,
        ?string $search = null,
        ?string $page = null
    ) {
        $this->checkUser($auth_user);
        $this->checkContract($contract);
        return $this->contractVariableRepository->list($contract, $filter, $search, $page);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkContract(?ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }
}
