<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToEditAWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldNotExistsException;

class EditWorkField
{

    private $userRepository;
    private $workFieldRepository;
    private $workFieldContributorRepository;

    public function __construct(
        UserRepository $userRepository,
        WorkFieldRepository $workFieldRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function handle(?User $auth_user, ?WorkField $work_field, array $data)
    {
        $this->checkWorkField($work_field);
        $this->checkUser($auth_user, $work_field);

        $work_field->setName(str_slug($data['display_name'], '_'));
        $work_field->setDisplayName($data['display_name']);
        $work_field->setDescription($data['description']);
        $work_field->setEstimatedBudget($data['estimated_budget']);
        $work_field->setStartedAt($data['started_at']);
        $work_field->setEndedAt($data['ended_at']);
        $work_field->setAddress($data['address']);
        $work_field->setExternalId($data['external_id']);
        $work_field->setProjectOwner($data['project_owner']);
        $work_field->setProjectManager($data['project_manager']);
        $work_field->setSpsCoordinator($data['sps_coordinator']);

        if (! empty($data['departments'])) {
            $work_field->unsetDepartments($work_field->getDepartments());
            $work_field->setDepartments($data['departments']);
        }

        return $this->workFieldRepository->save($work_field);
    }

    private function checkWorkField($work_field)
    {
        if (is_null($work_field)) {
            throw new WorkFieldNotExistsException;
        }
    }

    private function checkUser(?User $user, WorkField $work_field)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return true;
        }

        if (! ($this->workFieldRepository->isCreatorOf($user, $work_field) ||
            $this->workFieldContributorRepository->isAdminOf($user, $work_field) ||
            $this->userRepository->isAdminOf($user, $user->enterprise))) {
            throw new UserHasNotPermissionToEditAWorkFieldException;
        }
    }
}
