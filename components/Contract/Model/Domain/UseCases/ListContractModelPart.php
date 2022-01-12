<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListContractModelPart
{
    private $contractModelPartRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartRepositoryInterface $contractModelPartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->userRepository              = $userRepository;
    }

    public function handle(
        User $authUser,
        ContractModelEntityInterface $contract_model,
        ?array $filter = null,
        ?array $search = null
    ) {
        $this->checkUser($authUser);
        return $this->contractModelPartRepository->list($contract_model, $filter, $search);
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
