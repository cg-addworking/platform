<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListAnnexAsSupport implements ShouldQueue
{
    private $userRepository;
    private $annexRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param AnnexRepositoryInterface $annexRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, AnnexRepositoryInterface $annexRepository)
    {
        $this->userRepository = $userRepository;
        $this->annexRepository = $annexRepository;
    }

    /**
     * @param User|null $auth_user
     * @param array|null $filter
     * @param string|null $search
     * @param int|null $page
     * @param string|null $operator
     * @param string|null $field_name
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportException
     */
    public function handle(
        ?User $auth_user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->checkUser($auth_user);

        return $this->annexRepository->listAsSupport($auth_user, $filter, $search, $page, $operator, $field_name);
    }

    /**
     * @param User|null $auth_user
     * @throws UserIsNotAuthenticatedException
     * @throws UserIsNotSupportException
     */
    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }
}
