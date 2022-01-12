<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;

class AssociateMissionToContract
{
    private $missionRepository;
    private $contractRepository;

    public function __construct(
        MissionRepositoryInterface $missionRepository,
        ContractRepositoryInterface $contractRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->contractRepository = $contractRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract, array $inputs, array $validators = [])
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        $mission = $this->missionRepository->getOrCreateMissionFromInput($inputs, $contract);
        $this->checkMission($mission);

        $contract->setMission($mission);
        $this->contractRepository->save($contract);

        $sector_offer = $mission->getSectorOffer();
        $work_field = null;
        if (! is_null($sector_offer)) {
            $work_field = $sector_offer->getWorkField();
        } elseif ($mission->getWorkField()) {
            $work_field = $mission->getWorkField();
        }

        if (! is_null($work_field)) {
            $contract->setWorkfield($work_field);
            $this->contractRepository->save($contract);
        }

        return $mission;
    }

    public function checkContract(ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }

    private function checkMission($mission)
    {
        if (is_null($mission)) {
            throw new MissionIsNotFoundException();
        }
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
