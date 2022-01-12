<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsAlreadyArchivedException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAllowedToArchiveContractException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\App;

class ArchiveContract
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

    public function handle(User $auth_user, ?ContractEntityInterface $contract)
    {
        $this->check($auth_user, $contract);

        $contract->setArchivedAt();
        $contract->setArchivedBy($auth_user);

        $this->contractRepository->save($contract);

        App::make(ContractStateRepository::class)->updateContractState($contract);

        return $contract;
    }

    private function check(User $user, ContractEntityInterface $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }

        if (App::make(ContractStateRepository::class)->isArchived($contract)) {
            throw new ContractIsAlreadyArchivedException();
        }

        if (! $user->isSupport() && ! $this->userRepository->checkIfUserHasAccessTo($user, $contract)) {
            throw new UserIsNotAllowedToArchiveContractException();
        }
    }
}
