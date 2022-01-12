<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsDraftException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DuplicateContractModel
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

    public function handle(User $authUser, ContractModel $contract_model)
    {
        $this->checkUser($authUser);
        $this->checkContractModel($contract_model);


        $duplicate_model = $this->contractModelRepository->replicate($contract_model);
        $duplicate_model->setDuplicatedFrom($contract_model);
        $duplicate_model->setDisplayName($contract_model->display_name." copie");
        $duplicate_model->setDraft();
        $duplicate_model->setNumber();

        return $this->contractModelRepository->save($duplicate_model);
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

    private function checkContractModel($contract_model)
    {
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if ($this->contractModelRepository->isDraft($contract_model)) {
            throw new ContractModelIsDraftException();
        }
    }
}
