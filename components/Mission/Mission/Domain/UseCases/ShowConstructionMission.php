<?php

namespace Components\Mission\Mission\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Mission\Domain\Exceptions\MissionNotFoundException;
use Components\Mission\Mission\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Presenters\MissionShowPresenterInterface;
use Components\Mission\Mission\Domain\Exceptions\UserHasNotPermissionToShowMissionException;

class ShowConstructionMission
{
    private $missionRepository;
    private $userRepository;

    public function __construct(
        MissionRepositoryInterface $missionRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        MissionShowPresenterInterface $presenter,
        ?User $authenticated,
        ?MissionEntityInterface $mission
    ) {
        $this->check($authenticated, $mission);

        return $presenter->present($mission);
    }

    private function check(?User $user, ?MissionEntityInterface $mission)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($mission)) {
            throw new MissionNotFoundException;
        }

        if (! $this->missionRepository->isOwnerOfMission($this->userRepository->getEnterprises($user), $mission)
            && ! $this->userRepository->isSupport($user)
        ) {
            throw new UserHasNotPermissionToShowMissionException;
        }
    }
}
