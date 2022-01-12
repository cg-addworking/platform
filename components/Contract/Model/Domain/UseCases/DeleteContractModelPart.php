<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteContractModelPart
{
    private $contractModelPartRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        ContractModelVariableRepositoryInterface $contractModelVariableRepository,
        ContractModelPartRepositoryInterface $contractModelPartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelRepository     = $contractModelRepository;
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->userRepository              = $userRepository;
    }

    public function handle(User $authUser, ContractModelPartEntityInterface $contract_model_part)
    {
        $this->checkUser($authUser);
        $this->checkContractModelPart($contract_model_part);

        $this->contractModelVariableRepository->deleteVariables($contract_model_part);

        return $this->contractModelPartRepository->delete($contract_model_part);
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

    private function checkContractModelPart($contract_model_part)
    {
        if (is_null($contract_model_part)) {
            throw new ContractModelPartIsNotFoundException();
        }

        $contract_model = $contract_model_part->getContractModel();
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if ($this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsPublishedException();
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            throw new ContractModelIsArchivedException();
        }
    }
}
