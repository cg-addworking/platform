<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;

interface ContractModelPartRepositoryInterface
{
    public function make($data = []): ContractModelPartEntityInterface;
    public function findByNumber(int $number): ?ContractModelPartEntityInterface;
}
