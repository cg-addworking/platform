<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\FileNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateSignedAmendmentWithoutModel
{
    protected $userRepository;
    protected $enterpriseRepository;
    protected $contractRepository;
    protected $contractPartRepository;
    protected $contractPartyRepository;
    protected $contractStateRepository;
    protected $missionRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        ContractPartRepositoryInterface $contractPartRepository,
        ContractPartyRepositoryInterface $contractPartyRepository,
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ContractStateRepositoryInterface $contractStateRepository,
        MissionRepositoryInterface $missionRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->missionRepository = $missionRepository;
    }

    public function handle(?User $auth_user, array $inputs, $file, ContractEntityInterface $contract_parent)
    {
        $this->checkUser($auth_user, $contract_parent);
        $this->checkFile($file);

        $contract = $this->createContract($inputs['contract'], $contract_parent, $auth_user);
        $this->createContractPart($contract, $inputs['contract_part'], $file);
        $this->createContractParty($contract, $contract_parent, $inputs);

        $this->contractStateRepository->updateContractState($contract);
        $this->contractStateRepository->updateContractState($contract_parent);

        if (isset($inputs['contract']['with_mission'])) {
            $mission = $this->missionRepository->getOrCreateMissionFromInput($inputs['contract'], $contract);
            $this->checkMission($mission);

            $contract->setMission($mission);
            $this->contractRepository->save($contract);
        }

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

    private function checkMission($mission)
    {
        if (is_null($mission)) {
            throw new MissionIsNotFoundException();
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

    private function checkFile($file)
    {
        if (is_null($file)) {
            throw new FileNotExistsException();
        }
    }

    private function createContract(array $inputs, ContractEntityInterface $contract_parent, $auth_user)
    {
        $enterprise = $this->enterpriseRepository->find($inputs['enterprise']);
        $contract = $this->contractRepository->make();
        $contract->setParent($contract_parent);
        $contract->setEnterprise($enterprise);
        $contract->setName($inputs['name']);
        $contract->setExternalIdentifier($inputs['external_identifier']);
        $contract->setValidFrom($inputs['valid_from']);
        $contract->setValidUntil($inputs['valid_until']);
        $contract->setStatus(ContractEntityInterface::STATUS_SIGNED);
        $contract->setNumber();
        $contract->setCreatedBy($auth_user);

        return $this->contractRepository->save($contract);
    }

    private function createContractPart(Contract $contract, array $inputs, $file)
    {
        $file = $this->contractPartRepository->createFile($file);
        
        $contract_part = $this->contractPartRepository->make();
        $contract_part->setContract($contract);
        $contract_part->setFile($file);
        $contract_part->setDisplayName($inputs['display_name']);
        $contract_part->setName($inputs['display_name']);
        $contract_part->setNumber();

        return $this->contractPartRepository->save($contract_part);
    }

    private function createContractParty(Contract $contract, ContractEntityInterface $contract_parent, array $inputs)
    {
        foreach ($this->contractRepository->getSignatoryParties($contract_parent) as $parent_contract_party) {
            $signature_date = isset($inputs['contract_party'][$parent_contract_party->getOrder()]['signed_at']) ?
                $inputs['contract_party'][$parent_contract_party->getOrder()]['signed_at'] :
                null;
            $contract_party = $parent_contract_party->replicate();
            $contract_party->setContract($contract);
            $contract_party->setSignedAt($signature_date);
            $contract_party->setNumber();
            $contract_party_input = $inputs['contract_party'][$contract_party->getOrder()];
            $user = $this->userRepository->find($contract_party_input['signatory_id']);
            $contract_party->setSignatory($user);

            $this->contractPartyRepository->save($contract_party);
        }
    }
}
