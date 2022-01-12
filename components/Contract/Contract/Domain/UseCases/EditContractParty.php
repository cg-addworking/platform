<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

class EditContractParty
{
    protected $userRepository;
    protected $enterpriseRepository;
    protected $contractRepository;
    protected $contractPartyRepository;
    protected $contractVariableRepository;
    protected $contractStateRepository;
    protected $contractPartRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ContractRepositoryInterface $contractRepository,
        ContractPartyRepositoryInterface $contractPartyRepository,
        ContractVariableRepositoryInterface $contractVariableRepository,
        ContractStateRepositoryInterface $contractStateRepository,
        ContractPartRepositoryInterface $contractPartRepository
    ) {
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractRepository = $contractRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractStateRepository = $contractStateRepository;
        $this->contractPartRepository = $contractPartRepository;
    }

    public function handle(
        ?User $auth_user,
        ?ContractPartyEntityInterface $contract_party,
        array $inputs
    ) {
        $this->checkUser($auth_user);
        $this->checkContractParty($contract_party);

        if (! $this->userRepository->isSupport($auth_user)
            && ! $this->userRepository
                ->checkIfUserCanChangeContractPartySignatory($auth_user, $contract_party->getContract())) {
            return $contract_party;
        }

        $old_updated_at_date = $contract_party->getUpdatedAt();

        $contract_party = $this->updateContractParty($contract_party, $inputs, $auth_user);

        $contract_party = $this->contractPartyRepository->save($contract_party);
        
        if (!$old_updated_at_date->eq($contract_party->getUpdatedAt())
            && ! is_null($contract_party->getContractModelParty())
        ) {
            $this->deleteContractParts($contract_party);
            $this->updateVariables(
                $contract_party->getContract(),
                $contract_party->getContractModelParty(),
                $contract_party
            );
        }

        return $contract_party;
    }

    public function updateContractParty(?ContractPartyEntityInterface $contract_party, array $inputs, User $auth_user)
    {
        if ($this->userRepository->isSupport($auth_user)) {
            $contract_party->setDenomination($inputs['denomination']);
            $contract_party->setOrder($inputs['order']);

            $enterprise = $this->enterpriseRepository->find($inputs['enterprise_id']);
            $contract_party->setEnterprise($enterprise);
        }

        $signatory = $this->userRepository->find($inputs['signatory_id']);
        $contract_party->setSignatory($signatory);
        if (isset($inputs['signed_at'])) {
            $contract_party->setSignedAt($inputs['signed_at']);
        }

        $this->contractStateRepository->updateContractState($contract_party->getContract());

        return $contract_party;
    }

    public function updateVariables(
        ContractEntityInterface $contract,
        ContractModelPartyEntityInterface $contract_model_party,
        ContractPartyEntityInterface $contract_party
    ) {
        $this->contractVariableRepository->deleteNonSystemContractVariablesForParty($contract, $contract_party);
        $this->contractVariableRepository->createContractVariables(
            $contract,
            $contract_model_party,
            $contract_party
        );
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    private function checkContractParty($contract_party)
    {
        if (is_null($contract_party)) {
            throw new ContractPartyIsNotFoundException;
        }
    }

    private function deleteContractParts(ContractPartyEntityInterface $contract_party)
    {
        $contract = $contract_party->getContract();
        $contract_parts = $this->contractRepository->getContractParts($contract);
        foreach ($contract_parts as $contract_part) {
            if ($this->contractPartRepository->hasContractModelPart($contract_part)) {
                $this->contractPartRepository->delete($contract_part);
            }
        }
    }
}
