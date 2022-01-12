<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldNotExistsException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToDeleteAWorkFieldException;

class DeleteWorkField
{

    private $workFieldRepository;
    private $workFieldContributorRepository;

    public function __construct(
        WorkFieldRepository $workFieldRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function handle(?User $auth_user, ?WorkField $work_field)
    {
        $this->checkWorkField($work_field);
        $this->checkUser($auth_user, $work_field);

        return $this->workFieldRepository->delete($work_field);
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
            $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            throw new UserHasNotPermissionToDeleteAWorkFieldException;
        }
    }
}
