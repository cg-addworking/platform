<?php
namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateContractModelPartPreview
{
    private $contractModelPartRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartRepositoryInterface $contractModelPartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ContractModelPartEntityInterface $contract_model_part)
    {
        $this->checkUser($auth_user);
        $this->checkContractModelPart($contract_model_part);

        if ($contract_model_part->getShouldCompile()) {
            return $this->contractModelPartRepository->generate($contract_model_part);
        }

        return $this->contractModelPartRepository->download($contract_model_part);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModelPart($contract_model_part)
    {
        if (is_null($contract_model_part)) {
            throw new ContractModelPartIsNotFoundException();
        }
    }
}
