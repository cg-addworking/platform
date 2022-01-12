<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractAlreadyAssignedToMissionException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Mission\Mission\Application\Models\Mission;

class LinkContractAndMission
{
    public function handle(User $authenticated, ContractEntityInterface $contract, Mission $mission)
    {
        $this->checkUser($authenticated);
        $this->checkContract($contract);
        $this->checkMission($mission);

        return $contract->mission()->associate($mission)->save();
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkContract(ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        if (! is_null($contract->getMission())) {
            throw new ContractAlreadyAssignedToMissionException;
        }
    }

    private function checkMission($mission)
    {
        if (is_null($mission)) {
            throw new MissionIsNotFoundException;
        }
    }
}
