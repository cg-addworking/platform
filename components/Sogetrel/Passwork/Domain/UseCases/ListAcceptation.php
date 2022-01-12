<?php

namespace Components\Sogetrel\Passwork\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Sogetrel\Passwork\Domain\Exceptions\SearchFieldIsNotAllowedException;
use Components\Sogetrel\Passwork\Domain\Exceptions\UserEnterpriseIsNotPartOfSogetrelOrSubsidiaryException;
use Components\Sogetrel\Passwork\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListAcceptation
{
    protected $acceptationRepository;
    protected $userRepository;

    public function __construct(
        AcceptationRepositoryInterface $acceptationRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->acceptationRepository = $acceptationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        User $auth_user,
        ?array $filter,
        ?string $search,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->checkUser($auth_user);
        $this->checkSearch($field_name);

        return $this->acceptationRepository->list($filter, $search, $page, $operator, $field_name);
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($user) && ! $user->enterprise->isSogetrelOrSubsidiary()) {
            throw new UserEnterpriseIsNotPartOfSogetrelOrSubsidiaryException;
        }
    }

    public function checkSearch(?string $field_name)
    {
        if (isset($field_name)
            && !array_key_exists(
                $field_name,
                $this->acceptationRepository->getSearchableAttributes()
            )
        ) {
            throw new SearchFieldIsNotAllowedException;
        }
    }
}
