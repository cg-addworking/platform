<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\AmendmentCantBeCreatedFromAmendment;
use Components\Contract\Contract\Domain\Exceptions\FileNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\MissionAlreadyAssignedToAContractException;
use Components\Contract\Contract\Domain\Exceptions\MissionIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateAmendmentWithoutModelToSign
{
    protected $userRepository;
    protected $enterpriseRepository;
    protected $contractRepository;
    protected $contractPartRepository;
    protected $contractPartyRepository;
    protected $contractStateRepository;
    protected $missionRepository;
    protected $contractVariableRepository;

    public function __construct(
        ContractRepositoryInterface $contractRepository,
        ContractPartRepositoryInterface $contractPartRepository,
        ContractPartyRepositoryInterface $contractPartyRepository,
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ContractStateRepositoryInterface $contractStateRepository,
        MissionRepositoryInterface $missionRepository,
        ContractVariableRepositoryInterface $contractVariableRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->missionRepository = $missionRepository;
        $this->contractVariableRepository = $contractVariableRepository;
    }

    public function handle(?User $auth_user, array $inputs, $file, ContractEntityInterface $contract_parent)
    {
        $this->checkContractParent($contract_parent);
        $this->checkUser($auth_user, $contract_parent);
        $this->checkFile($file);

        $contract = $this->createContract($inputs['contract'], $contract_parent, $auth_user);
        $this->createContractPart($contract, $inputs['contract_part'], $file);
        $this->createContractParty($contract, $contract_parent, $inputs);

        $this->contractStateRepository->updateContractState($contract);
        $this->contractRepository->save($contract);

        if (isset($inputs['contract']['with_mission'])) {
            $mission = $this->missionRepository->getOrCreateMissionFromInput($inputs['contract'], $contract);
            $this->checkMission($mission);

            $contract->setMission($mission);
            $this->contractRepository->save($contract);

            $work_field = null;
            if (! is_null($mission->getWorkField())) {
                $work_field = $mission->getWorkField();
            } elseif (! is_null($mission->getSectorOffer())) {
                $work_field = $mission->getSectorOffer()->getWorkField();
            }

            if (! is_null($work_field)) {
                $contract->setWorkfield($work_field);
                $this->contractRepository->save($contract);
            }
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

    private function checkContractParent(ContractEntityInterface $contract_parent)
    {
        if ($this->contractRepository->isAmendment($contract_parent)) {
            throw new AmendmentCantBeCreatedFromAmendment();
        }
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
        $contract = $this->contractRepository->make();
        $contract->setEnterprise($contract_parent->getEnterprise());
        $contract->setName($inputs['name']);
        $contract->setExternalIdentifier($inputs['external_identifier']);
        $contract->setValidFrom($inputs['valid_from']);
        $contract->setValidUntil($inputs['valid_until']);
        $contract->setNumber();
        $contract->setParent($contract_parent);
        $contract->setCreatedBy($auth_user);

        return $this->contractRepository->save($contract);
    }

    private function createContractPart(Contract $contract, array $inputs, $file)
    {
        return $this->contractPartRepository->createContractPartFromInput($contract, $inputs, $file);
    }

    private function createContractParty(Contract $contract, ContractEntityInterface $contract_parent, $inputs)
    {
        foreach ($this->contractRepository->getSignatoryParties($contract_parent) as $parent_contract_party) {
            /* @var ContractParty $contract_party */
            $contract_party = $parent_contract_party->replicate();
            $contract_party->setContract($contract);
            $contract_party->setSignedAt(null);
            $contract_party->setNumber();
            $contract_party->setSignaturePosition(
                $this->contractPartyRepository->calculateSignaturePosition($parent_contract_party->getOrder())
            );
            $contract_party_input = $inputs['contract_party'][$contract_party->getOrder()];
            $user = $this->userRepository->find($contract_party_input['signatory_id']);
            $contract_party->setSignatory($user);
            $contract_party->setSignatoryName($user->name);

            $this->contractPartyRepository->save($contract_party);
        }
    }
}
