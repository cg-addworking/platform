<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ListContractParty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $contractPartyRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractPartyRepositoryInterface $contractPartyRepository
    ) {
        $this->userRepository     = $userRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle(?User $auth_user, ContractEntityInterface $contract)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        return $this->contractPartyRepository->list($contract);
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkContract(ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }
}
