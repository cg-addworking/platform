<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListContractModelAsSupport
{
    private $contractModelRepository;
    private $userRepository;

    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository          = $userRepository;
    }

    public function handle(
        User $authUser,
        ?array $filter,
        ?string $search,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->checkUser($authUser);
        return $this->contractModelRepository->list($filter, $search, $page, $operator, $field_name);
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
