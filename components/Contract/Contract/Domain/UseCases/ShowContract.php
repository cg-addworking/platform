<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;

class ShowContract
{
    public function handle(User $authUser, ?ContractEntityInterface $contract)
    {
        $this->checkUser($authUser);
        $this->checkContract($contract);

        return $contract;
    }

    private function checkUser(?User $user)
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
