<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Illuminate\Support\Collection;

interface ContractModelVariableRepositoryInterface
{
    public function make($data = []): ContractModelVariableEntityInterface;
    public function save(ContractModelVariableEntityInterface $contract_model_variable);
    public function list(ContractModelEntityInterface $contract_model, ?array $filter = null, ?string $search = null);
    public function findVariables(string $content): array;
    public function deleteVariables(ContractModelPartEntityInterface $contract_model_part): bool;
    public function deleteVariable(ContractModelVariable $contract_model_variable);
    public function setVariables(Collection $variables, ContractModelPartEntityInterface $contract_model_part);
    public function setVariable(
        string $variable,
        ContractModelPartEntityInterface $contract_model_part,
        int $order
    );
    public function findByNumber(int $number): ?ContractModelVariableEntityInterface;
    public function getAvailableInputTypes(bool $trans = false): array;
    public function refreshVariables(ContractModelPartEntityInterface $contract_model_part, $new_variables);
}
