<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Notifications\ContractNeedsDocumentsNotification;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractDoesHavePartiesException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserCantBeSignatoryOfContractPartyException;
use Components\Contract\Contract\Domain\Exceptions\UserCantBeValidatorAndSignatoryException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Notification;

class IdentifyParty
{
    private $contractPartyRepository;
    private $contractModelPartyRepository;
    private $enterpriseRepository;
    private $contractRepository;
    private $userRepository;
    private $contractVariableRepository;
    private $contractStateRepository;

    public function __construct(
        ContractPartyRepositoryInterface $contractPartyRepository,
        ContractModelPartyRepositoryInterface $contractModelPartyRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ContractRepository $contractRepository,
        UserRepositoryInterface $userRepository,
        ContractVariableRepositoryInterface $contractVariableRepository,
        ContractStateRepositoryInterface $contractStateRepository
    ) {
        $this->contractPartyRepository = $contractPartyRepository;
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractRepository = $contractRepository;
        $this->userRepository = $userRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract, array $inputs)
    {
        $this->checkUser($auth_user, $contract);
        $this->checkContractParties($contract);

        $enterprise = $this->enterpriseRepository->find($inputs['enterprise_id']);
        $this->checkEnterprise($enterprise, $contract);

        $signatory = $this->userRepository->find($inputs['signatory_id']);
        $this->checkSignatory($signatory, $enterprise);

        $contract_model_party = $this->contractModelPartyRepository->find($inputs['contract_model_party_id']);

        $contract_party = $this->contractPartyRepository->make();
        $contract_party->setContract($contract);
        $contract_party->setEnterprise($enterprise);
        $contract_party->setEnterpriseName($enterprise->name);
        $contract_party->setContractModelParty($contract_model_party);
        $contract_party->setSignatory($signatory);
        $contract_party->setSignatoryName($signatory->name);
        $contract_party->setDenomination($inputs['denomination']);
        $contract_party->setOrder($inputs['order']);
        $contract_party->setNumber();
        $contract_party->setSignaturePosition(
            $this->contractPartyRepository->calculateSignaturePosition($inputs['order'])
        );
        $saved = $this->contractPartyRepository->save($contract_party);

        $party = $this->contractPartyRepository->getUserValidatorParty($signatory, $contract);
        if ($party) {
            $this->contractPartyRepository->delete($party);
        }

        $this->contractStateRepository->updateContractState($contract);

        return $saved;
    }

    private function checkUser($user, $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if ($this->userRepository->isSupport($user)) {
            return true;
        }

        if (! $user->enterprises->contains($contract->getEnterprise())) {
            throw new UserIsNotMemberOfTheContractEnterpriseException();
        }

        return true;
    }

    private function checkEnterprise($enterprise, $contract)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException();
        }

        if (! $this->enterpriseRepository->hasPartnershipWithContract($enterprise, $contract)) {
            throw new EnterpriseDoesntHavePartnershipWithContractException();
        }
    }

    private function checkContractParties($contract)
    {
        if ($this->contractRepository->getSignatoryParties($contract)->count() ==
            $contract->getContractModel()->getParties()->count()) {
            throw new ContractDoesHavePartiesException();
        }
    }

    private function checkSignatory(User $signatory, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->getSignatoriesOf($enterprise)->contains($signatory)) {
            throw new UserCantBeSignatoryOfContractPartyException();
        }
    }
}
