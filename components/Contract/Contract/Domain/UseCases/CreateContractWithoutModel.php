<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\FileNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\MissionAlreadyAssignedToAContractException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateContractWithoutModel
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

    public function handle(?User $auth_user, array $inputs, $file)
    {
        $this->checkUser($auth_user);
        $this->checkFile($file);

        $contract = $this->createContract($inputs['contract'], $auth_user);
        $this->createContractPart($contract, $inputs['contract_part'], $file);
        foreach ($inputs['contract_party'] as $party) {
            $this->createContractParty($contract, $party);
        }

        $contract = $this->contractStateRepository->updateContractState($contract);

        if (isset($inputs['contract']['with_mission'])) {
            $mission = $this->missionRepository->getOrCreateMissionFromInput($inputs['contract'], $contract);
            $this->checkMission($mission);
            $contract->mission()->associate($mission)->save();
        }

        ActionTrackingHelper::track(
            $auth_user,
            ActionEntityInterface::CREATE_CONTRACT,
            $contract,
            __('components.contract.contract.application.tracking.create_contract')
        );

        return $contract;
    }

    private function checkMission($mission)
    {
        if (is_null($mission)) {
            throw new MissionIsNotFoundException();
        }
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkFile($file)
    {
        if (is_null($file)) {
            throw new FileNotExistsException();
        }
    }

    private function createContract(array $inputs, $auth_user)
    {
        $contract = $this->contractRepository->make();
        $contract->setEnterprise($inputs['enterprise']);
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

    private function createContractParty(Contract $contract, array $inputs)
    {
        $enterprise = $this->enterpriseRepository->find($inputs['enterprise_id']);
        $signatory = $this->userRepository->find($inputs['signatory_id']);

        $contract_party = $this->contractPartyRepository->make();
        $contract_party->setContract($contract);
        $contract_party->setEnterprise($enterprise);
        $contract_party->setEnterpriseName($enterprise->name);
        $contract_party->setSignatory($signatory);
        $contract_party->setSignatoryName($signatory->name);
        $contract_party->setDenomination($inputs['denomination']);
        $contract_party->setOrder($inputs['order']);
        $contract_party->setSignedAt($inputs['signed_at']);
        $contract_party->setNumber();

        return $this->contractPartyRepository->save($contract_party);
    }
}
