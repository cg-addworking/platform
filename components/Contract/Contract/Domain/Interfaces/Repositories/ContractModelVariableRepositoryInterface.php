<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;

interface ContractModelVariableRepositoryInterface
{
    public function make($data = []): ContractModelVariableEntityInterface;
    public function findByNumber(string $number): ?ContractModelVariableEntityInterface;
}
