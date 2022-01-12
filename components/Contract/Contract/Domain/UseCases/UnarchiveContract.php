<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Illuminate\Support\Facades\App;

class UnarchiveContract
{
    private $contractRepository;

    public function __construct(ContractRepositoryInterface $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function handle(User $auth_user, ?ContractEntityInterface $contract)
    {
        $this->check($auth_user, $contract);

        $contract->archived_at = null;
        $contract->setArchivedBy(null);

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
    }
}
