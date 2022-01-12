<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNoAccessToWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToShowAWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Presenters\WorkFieldShowPresenterInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldContributorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class ShowWorkField
{
    protected $workFieldRepository;
    protected $workFieldContributorRepository;
    protected $userRepository;

    public function __construct(
        WorkFieldRepositoryInterface $workFieldRepository,
        UserRepositoryInterface $userRepository,
        WorkFieldContributorRepositoryInterface $workFieldContributorRepository
    ) {
        $this->workFieldRepository = $workFieldRepository;
        $this->userRepository = $userRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function handle(
        WorkFieldShowPresenterInterface $workFieldShowPresenter,
        ?User $authUser,
        ?WorkFieldEntityInterface $work_field
    ) {
        $this->checkWorkField($work_field);
        $this->checkUser($authUser, $work_field);

        return $workFieldShowPresenter->present($work_field);
    }

    private function checkUser(?User $user, WorkFieldEntityInterface $work_field)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if ($this->userRepository->isSupport($user)) {
            throw new UserHasNotPermissionToShowAWorkFieldException;
        }
        
        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isContributorOf($user, $work_field)
            || $this->userRepository->isAdminOf($user, $user->enterprise)
            || $this->userRepository->hasWorkfieldCreatorRole($user, $user->enterprise))) {
            throw new UserHasNotPermissionToShowAWorkFieldException();
        }
    }

    private function checkWorkField(?WorkFieldEntityInterface $work_field)
    {
        if (is_null($work_field)) {
            throw new WorkFieldIsNotFoundException();
        }
    }
}
