<?php

namespace Components\Enterprise\Enterprise\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Enterprise\Domain\Exceptions\CompanyNotFoundException;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\UserRepositoryInterface;

class ShowCompany
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(User $authUser, ?CompanyEntityInterface $company)
    {
        $this->checkUser($authUser);
        $this->checkCompany($company);

        return $company;
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkCompany(?CompanyEntityInterface $company)
    {
        if (is_null($company)) {
            throw new CompanyNotFoundException();
        }
    }
}
