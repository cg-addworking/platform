<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Domain\Exceptions\AmendmentCantBeCreatedFromAmendment;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotPublishedException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHaveAccessToContractModelException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;

class CreateAmendment
{
    private $contractModelRepository;
    private $contractRepository;
    private $enterpriseRepository;
    private $contractPartyRepository;
    private $userRepository;
    private $contractStateRepository;
    private $contractVariableRepository;
    private $contractModelPartyRepository;
    private $missionRepository;


    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        ContractRepositoryInterface $contractRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ContractPartyRepositoryInterface $contractPartyRepository,
        UserRepositoryInterface $userRepository,
        ContractStateRepositoryInterface $contractStateRepository,
        ContractVariableRepositoryInterface $contractVariableRepository,
        ContractModelPartyRepository $contractModelPartyRepository,
        MissionRepositoryInterface $missionRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->contractRepository = $contractRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->missionRepository = $missionRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract_parent, array $inputs)
    {
        $this->checkUser($auth_user, $contract_parent);
        $this->checkContractParent($contract_parent);

        $enterprise = $contract_parent->getEnterprise();
        $this->checkEnterprise($enterprise);

        $contract_model = isset($inputs['contract']['contract_model'])
            ? $this->contractModelRepository->find($inputs['contract']['contract_model'])
            : null;

        $this->checkContractModel($enterprise, $contract_model);

        $contract = $this->createContract(
            $contract_parent,
            $inputs['contract'],
            $enterprise,
            $contract_model,
            $auth_user
        );

        $this->createContractParty($contract, $contract_parent, $contract_model, $inputs);
        $contract = $this->contractStateRepository->updateContractState($contract);

        $this->track($auth_user, $contract, $contract_parent);

        return $contract;
    }

    private function track($auth_user, $contract, $contract_parent)
    {
        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CREATE_CONTRACT,
            $contract,
            __('components.contract.contract.application.tracking.create_contract')
        );

        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CREATE_AMENDMENT,
            $contract_parent,
            __(
                'components.contract.contract.application.tracking.create_amendment',
                [
                    'amendment_name' => $contract->getName(),
                ]
            )
        );
    }

    private function checkContractParent(ContractEntityInterface $contract_parent)
    {
        if ($this->contractRepository->isAmendment($contract_parent)) {
            throw new AmendmentCantBeCreatedFromAmendment();
        }
    }

    private function checkContractModel($enterprise, $contract_model = null)
    {
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if (!$this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsNotPublishedException();
        }

        if (! $this->enterpriseRepository->hasAccessToContractModel($enterprise, $contract_model)) {
            throw new EnterpriseDoesntHaveAccessToContractModelException();
        }
    }

    private function checkUser($user, $contract_parent)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)
            && !$user->enterprises()->get()->contains($contract_parent->getEnterprise())) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException();
        }
    }

    private function createContract(
        ContractEntityInterface $contract_parent,
        $inputs,
        $enterprise,
        $contract_model,
        $auth_user
    ) {
        $contract = $this->contractRepository->make();
        $contract->setEnterprise($enterprise);
        $contract->setContractModel($contract_model);
        $contract->setName($inputs['name']);
        $contract->setExternalIdentifier($inputs['external_identifier']);
        $contract->setValidFrom($inputs['valid_from']);
        $contract->setValidUntil($inputs['valid_until']);
        $contract->setNumber();
        $contract->setParent($contract_parent);
        $contract->setCreatedBy($auth_user);
        return $this->contractRepository->save($contract);
    }

    public function createContractParty(
        ContractEntityInterface $contract,
        ContractEntityInterface $contract_parent,
        ContractModelEntityInterface $contract_model,
        $inputs
    ) {
        foreach ($this->contractRepository->getSignatoryParties($contract_parent) as $parent_contract_party) {
            $contract_party = $parent_contract_party->replicate();
            $contract_party->setContract($contract);
            $contract_party->setSignedAt(null);
            $contract_party->setNumber();
            $contract_party->setSignaturePosition(
                $this->contractPartyRepository->calculateSignaturePosition($parent_contract_party->getOrder())
            );
            $contract_party->setContractModelParty(
                $this->contractModelPartyRepository->findByOrder(
                    $contract_model,
                    $parent_contract_party->getOrder()
                )
            );
            if (array_key_exists('contract_party', $inputs)) {
                $contract_party_input = $inputs['contract_party'][$contract_party->getOrder()];
                $contract_party->setSignatory($this->userRepository->find($contract_party_input['signatory_id']));
            }
            $this->contractPartyRepository->save($contract_party);
        }
    }
}
