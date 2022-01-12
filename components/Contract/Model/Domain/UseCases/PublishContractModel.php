<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\MinimumPartiesNotReachedException;
use Components\Contract\Model\Domain\Exceptions\MinimumPartsNotReachedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class PublishContractModel
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

        $this->checkParties($contract_model);
        $this->checkParts($contract_model);

        $contract_model->setPublishedAt();
        $contract_model->setPublishedBy($auth_user);

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

        if ($this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsPublishedException();
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            throw new ContractModelIsArchivedException();
        }
    }

    private function checkParties($contract_model)
    {
        if ($contract_model->getParties()->count() < 2) {
            throw new MinimumPartiesNotReachedException();
        }
    }

    private function checkParts($contract_model)
    {
        if ($contract_model->getParts()->count() < 1) {
            throw new MinimumPartsNotReachedException();
        }
    }
}
