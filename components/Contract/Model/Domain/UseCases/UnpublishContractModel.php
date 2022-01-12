<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotPublishedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Domain\Exceptions\ContractModelHasContractsException;

class UnpublishContractModel
{
    private $contractModelRepository;
    private $userRepository;

    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(User $auth_user, ContractModelEntityInterface $contract_model)
    {
        $this->checkUser($auth_user);
        $this->checkContractModel($contract_model);

        $contract_model->setDraft();
        $contract_model->setPublishedBy(null);

        return $this->contractModelRepository->save($contract_model);
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

        if (! $this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsNotPublishedException();
        }
        
        if ($this->contractModelRepository->checkIfModelAttachedToContract($contract_model) > 0) {
            throw new ContractModelHasContractsException();
        }
    }
}
