<?php

namespace Components\Mission\Mission\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Mission\Domain\Exceptions\CannotEditMissionInThisStatusException;
use Components\Mission\Mission\Domain\Exceptions\MissionNotFoundException;
use Components\Mission\Mission\Domain\Exceptions\UserHasNotPermissionToEditMissionException;
use Components\Mission\Mission\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Mission\Domain\Exceptions\UserNotFoundException;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;

class EditConstructionMission
{
    private $missionRepository;
    private $userRepository;
    private $costEstimationRepository;

    public function __construct(
        MissionRepositoryInterface $missionRepository,
        UserRepositoryInterface $userRepository,
        CostEstimationRepositoryInterface $costEstimationRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->userRepository = $userRepository;
        $this->costEstimationRepository = $costEstimationRepository;
    }

    public function handle(
        ?User $auth_user,
        ?MissionEntityInterface $mission,
        array $inputs,
        $files = [],
        $cost_estimation_file = []
    ) {
        $referent = $this->userRepository->find($inputs['referent_id']);
        $this->checkUser($auth_user, $referent);
        $this->checkMission($auth_user, $mission);

        $mission->setLabel($inputs['label']);
        $mission->setStartsAt($inputs['starts_at']);
        $mission->setEndsAt($inputs['ends_at']);
        $mission->setDescription($inputs['description']);
        $mission->setExternalId($inputs['external_id']);
        $mission->setAnalyticCode($inputs['analytic_code']);
        $mission->setReferent($referent);
        $mission->setAmount($inputs['amount']);

        $updated = $this->missionRepository->save($mission);

        if (! empty($inputs['departments'])) {
            $updated->unsetDepartments($updated->getDepartments());
            $updated->setDepartments($inputs['departments']);
        }

        if (! empty($files)) {
            $this->missionRepository->createFiles($files, $updated);
        }

        $this->handleCostEstimation($inputs, $mission, $cost_estimation_file);

        return $updated;
    }

    private function handleCostEstimation($inputs, $mission, $cost_estimation_file)
    {
        $amount_before_taxes = 0;
        if (array_key_exists('cost_estimation', $inputs)
            && array_key_exists('amount_before_taxes', $inputs['cost_estimation'])) {
            $amount_before_taxes = $inputs['cost_estimation']['amount_before_taxes'];
        }

        $cost_estimation = $mission->getCostEstimation();
        if (!is_null($cost_estimation)) {
            $this->costEstimationRepository->edit(
                $cost_estimation,
                $amount_before_taxes,
                $cost_estimation_file
            );
        } else {
            $cost_estimation = $this->costEstimationRepository->create(
                $amount_before_taxes,
                $cost_estimation_file
            );
            $mission->setCostEstimation($cost_estimation);
            $this->missionRepository->save($mission);
        }
    }

    private function checkUser(?User $user, ?User $referent)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($referent)) {
            throw new UserNotFoundException;
        }
    }

    private function checkMission(?User $user, ?MissionEntityInterface $mission)
    {
        if (is_null($mission)) {
            throw new MissionNotFoundException;
        }

        if (! $this->missionRepository->isOwnerOfMission($this->userRepository->getEnterprises($user), $mission)
            && ! $this->userRepository->isSupport($user)
        ) {
            throw new UserHasNotPermissionToEditMissionException;
        }

        if ($mission->getStatus() !== MissionEntityInterface::STATUS_DRAFT
            && $mission->getStatus() !== MissionEntityInterface::STATUS_READY_TO_START) {
            throw new CannotEditMissionInThisStatusException;
        }
    }
}
