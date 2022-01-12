<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotPublishedException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHaveAccessToContractModelException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\MissionAlreadyAssignedToAContractException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateContract
{
    private $contractModelRepository;
    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;

    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        ContractRepositoryInterface $contractRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository,
        ContractStateRepositoryInterface $contractStateRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->contractRepository = $contractRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(User $auth_user, array $inputs)
    {
        $this->checkUser($auth_user);
        $enterprise = $this->enterpriseRepository->find($inputs['enterprise']);
        $this->checkEnterprise($enterprise);

        $contract_model = $this->contractModelRepository->find($inputs['contract_model']);
        $this->checkContractModel($contract_model, $enterprise);

        $contract = $this->createContract($inputs, $enterprise, $contract_model, $auth_user);

        $contract = $this->contractRepository->save($contract);
        $contract = $this->contractStateRepository->updateContractState($contract);

        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CREATE_CONTRACT,
            $contract,
            __('components.contract.contract.application.tracking.create_contract')
        );

        return $contract;
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException();
        }
    }

    private function checkContractModel($contract_model, $enterprise)
    {
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if (! $this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsNotPublishedException();
        }

        if (! $this->enterpriseRepository->hasAccessToContractModel($enterprise, $contract_model)) {
            throw new EnterpriseDoesntHaveAccessToContractModelException();
        }
    }

    private function createContract($inputs, $enterprise, $contract_model, $auth_user)
    {
        $contract = $this->contractRepository->make();
        $contract->setEnterprise($enterprise);
        $contract->setContractModel($contract_model);
        $contract->setName($inputs['name']);
        $contract->setExternalIdentifier($inputs['external_identifier'] ?? null);
        $contract->setValidFrom($inputs['valid_from']);
        $contract->setValidUntil($inputs['valid_until']);
        $contract->setNumber();
        $contract->setCreatedBy($auth_user);

        return $contract;
    }
}
