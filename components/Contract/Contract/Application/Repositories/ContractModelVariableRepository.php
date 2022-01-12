<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;

class ContractModelVariableRepository implements ContractModelVariableRepositoryInterface
{
    public function make($data = []): ContractModelVariableEntityInterface
    {
        return new ContractModelVariable($data);
    }

    public function findByNumber(string $number): ?ContractModelVariableEntityInterface
    {
        return ContractModelVariable::where('number', $number)->first();
    }
}
