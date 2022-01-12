<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserCantDetachContributorException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldContributorIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldContributorEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;

class DetachContributorToWorkField
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

    public function handle(
        ?User $authenticated,
        ?WorkFieldContributorEntityInterface $work_field_contributor
    ) {
        $this->checkWorkFieldContributor($work_field_contributor);
        $this->checkAuthenticated($authenticated, $work_field_contributor);

        return $this->workFieldContributorRepository->delete($work_field_contributor);
    }

    private function checkWorkFieldContributor(?WorkFieldContributorEntityInterface $work_field_contributor)
    {
        if (is_null($work_field_contributor)) {
            throw new WorkFieldContributorIsNotFoundException;
        }
    }

    private function checkAuthenticated(?User $user, WorkFieldContributorEntityInterface $work_field_contributor)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        $work_field = $work_field_contributor->getWorkField();

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return true;
        }

        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            throw new UserCantDetachContributorException;
        }
    }
}
