<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToListWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Interfaces\Presenters\WorkFieldListPresenterInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldContributorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class ListWorkField
{

    private $userRepository;
    private $workFieldRepository;
    private $workFieldContributorRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        WorkFieldRepositoryInterface $workFieldRepository,
        WorkFieldContributorRepositoryInterface $workFieldContributorRepository
    ) {
        $this->userRepository      = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function handle(
        WorkFieldListPresenterInterface $presenter,
        ?User $auth_user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->checkUser($auth_user);

        return $presenter->present(
            $this->workFieldRepository->list($auth_user, $filter, $search, $page, $operator, $field_name)
        );
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }
}
