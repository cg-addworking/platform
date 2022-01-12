<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsPublishedException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class EditContract
{
    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository,
        ContractStateRepositoryInterface $contractStateRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract, array $inputs)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        $this->updateContract($contract, $inputs, $auth_user);

        return $this->contractRepository->save($contract);
    }

    private function updateContract(
        ContractEntityInterface $contract,
        array $inputs,
        $auth_user
    ) {
        $contract->setName($inputs['name']);
        $contract->setExternalIdentifier($inputs['external_identifier']);

        if ($this->userRepository->isSupport($auth_user) ||
            $auth_user->enterprises()->get()->contains($contract->getEnterprise())
        ) {
            if (isset($inputs['valid_from'])) {
                $contract->setValidFrom($inputs['valid_from']);
            }
            if (isset($inputs['valid_until'])) {
                $contract->setValidUntil($inputs['valid_until']);
            }

            $this->contractStateRepository->updateContractState($contract);
        }
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

    private function checkContract($contract)
    {
        if ($contract->isPublished()) {
            throw new ContractIsPublishedException();
        }
    }
}
