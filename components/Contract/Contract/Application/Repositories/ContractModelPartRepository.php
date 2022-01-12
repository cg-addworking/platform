<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;

class ContractModelPartRepository implements ContractModelPartRepositoryInterface
{
    public function make($data = []): ContractModelPartEntityInterface
    {
        return new ContractModelPart($data);
    }

    public function findByNumber(int $number): ?ContractModelPartEntityInterface
    {
        return ContractModelPart::where('number', $number)->first();
    }
}
