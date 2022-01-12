<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractStateIsDraftException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Exceptions\UserNotAllowedToDownloadContractException;

class DownloadContract
{
    private $userRepository;
    private $contractRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractRepository $contractRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
    }

    public function handle(User $user, ?ContractEntityInterface $contract)
    {
        $this->check($user, $contract);
        return $this->contractRepository->download($contract);
    }

    private function check(User $user, ?ContractEntityInterface $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        if ($contract->getState() == ContractEntityInterface::STATE_DRAFT) {
            throw new ContractStateIsDraftException;
        }

        if (! $this->userRepository->isSupport($user)
            && ! $this->userRepository->checkIfUserHasAccessTo($user, $contract)
            && ! $this->contractRepository->isPartyOf($user, $contract)
        ) {
            throw new UserNotAllowedToDownloadContractException;
        }
    }
}
