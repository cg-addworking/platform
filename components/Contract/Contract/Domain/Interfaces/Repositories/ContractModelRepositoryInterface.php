<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;

interface ContractModelRepositoryInterface
{
    public function find(string $id): ?ContractModelEntityInterface;
    public function findByNumber(string $number): ?ContractModelEntityInterface;
    public function isPublished($contract_model): bool;
    public function make(): ContractModelEntityInterface;
}
