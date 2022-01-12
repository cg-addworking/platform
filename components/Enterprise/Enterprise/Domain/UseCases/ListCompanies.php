<?php

namespace Components\Enterprise\Enterprise\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Enterprise\Domain\Exceptions\SearchFieldIsNotAllowedException;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Enterprise\Domain\Interfaces\CompanyRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\UserRepositoryInterface;

class ListCompanies
{
    private $companyRepository;
    private $userRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->userRepository       = $userRepository;
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
        
        return $this->companyRepository->listAsSupport($filter, $search, $page, $operator, $field_name);
    }

    public function checkSearch(?string $field_name)
    {
        if (isset($field_name)
            && !array_key_exists(
                $field_name,
                $this->companyRepository->getSearchableAttributes()
            )
        ) {
            throw new SearchFieldIsNotAllowedException;
        }
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }
}
