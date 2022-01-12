<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyCanNotBeDeletedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteContractModelParty
{
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartyRepositoryInterface $contractModelPartyRepository,
        ContractModelRepositoryInterface $contractModelRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->contractModelRepository      = $contractModelRepository;
        $this->userRepository               = $userRepository;
    }

    public function handle(User $auth_user, ContractModelParty $contract_model_party)
    {
        $this->checkUser($auth_user);

        $this->checkContractModelParty($contract_model_party);

        $this->checkDeletingAbility($contract_model_party);

        $deleted = $this->contractModelPartyRepository->delete($contract_model_party);

        if ($deleted) {
            $this->orderParties($contract_model_party->getContractModel());
        }

        return $deleted;
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

    private function checkContractModelParty($contract_model_party)
    {
        if (is_null($contract_model_party)) {
            throw new ContractModelPartyIsNotFoundException();
        }

        $contract_model = $contract_model_party->getContractModel();

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

    private function checkDeletingAbility($contract_model_party)
    {
        if (! $this->contractModelPartyRepository->isDeletable($contract_model_party)) {
            throw new ContractModelPartyCanNotBeDeletedException();
        }
    }

    private function orderParties($contract_model): void
    {
        $order = 1;
        foreach ($contract_model->getParties()->sortBy('order') as $party) {
            $party->update(['order' => $order]);
            $order++;
        }
    }
}
