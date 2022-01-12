<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrCreatorException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteContract
{
    private $contractRepository;
    private $userRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract)
    {
        $this->checkUser($auth_user, $contract);
        $this->checkContract($contract);

        return $this->contractRepository->delete($contract);
    }

    private function checkUser($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (!$this->userRepository->isSupport($user)
            && !($user->getId() === $contract->getCreatedBy()->getId())
            && !$this->userRepository->checkIfUserHasAccessTo($user, $contract)
        ) {
            throw new UserIsNotSupportOrCreatorException;
        }

        return true;
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }
}
