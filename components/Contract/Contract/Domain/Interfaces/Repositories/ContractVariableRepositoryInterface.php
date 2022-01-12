<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractVariableEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;

interface ContractVariableRepositoryInterface
{
    public function make($data = []): ContractVariableEntityInterface;
    public function list(
        ContractEntityInterface $contract,
        ?array $filter = null,
        ?string $search = null,
        ?string $page = null
    );
    public function save(ContractVariableEntityInterface $contract_variable);
    public function find($id): ?ContractVariableEntityInterface;
    public function findMany(array $ids, array $with = []);
    public function getContractVariableForEnterprise($enterprises, ContractEntityInterface $contract);
    public function getAllContractVariable(ContractEntityInterface $contract);
    public function getSystemContractVariables(ContractEntityInterface $contract);
    public function isSystemVariable(ContractVariableEntityInterface $contract_variable);
    public function getNonSystemContractVariables(ContractEntityInterface $contract);
    public function checkIfAllRequiredVariablesHasValue(ContractEntityInterface $contract): bool;
    public function createContractVariables(
        ContractEntityInterface $contract,
        ContractModelPartyEntityInterface $contract_model_party,
        ContractPartyEntityInterface $contract_party
    );
    public function setVariableValue(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        ContractModelVariableEntityInterface $contract_model_variable
    );
    public function delete(ContractVariableEntityInterface $contract_variable): bool;
    public function deleteNonSystemContractVariablesForParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    );
    public function getVariables(ContractEntityInterface $contract);
    public function isDeleted(ContractVariableEntityInterface $contract_variable);
    public function checkIfVariablesMustBeEdited(ContractEntityInterface $contract): bool;
    public function checkIfAllVariablesAreSystemVariables(ContractEntityInterface $contract): bool;
    public function isLongText(ContractVariableEntityInterface $contract_variable): bool;
    public function isOptions(ContractVariableEntityInterface $contract_variable): bool;
    public function isDate(ContractVariableEntityInterface $contract_variable): bool;
    public function getUserFillableContractVariable(
        ContractEntityInterface $contract,
        User $user,
        ?ContractPartEntityInterface $part = null
    );
    public function updateObjectValuesFromSystemVariables(
        ContractVariableEntityInterface $contract_variable,
        User $user
    );
}
