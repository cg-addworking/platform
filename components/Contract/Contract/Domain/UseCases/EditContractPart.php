<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractPartNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;

class EditContractPart
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(
        ?User $auth_user,
        ?ContractPart $contract_part,
        array $inputs
    ) {
        $this->checkUser($auth_user);
        $this->checkContractPart($contract_part);

        $contract_part->setIsHidden($inputs['is_hidden']);
        $contract_part->save();

        return $contract_part;
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkContractPart($contract_part)
    {
        if (is_null($contract_part)) {
            throw new ContractPartNotExistsException;
        }
    }
}
