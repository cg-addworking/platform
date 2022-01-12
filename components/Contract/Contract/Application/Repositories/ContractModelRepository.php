<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;

class ContractModelRepository implements ContractModelRepositoryInterface
{
    public function find(string $id): ?ContractModelEntityInterface
    {
        return ContractModel::where('id', $id)->first();
    }

    public function findByNumber(string $number): ?ContractModelEntityInterface
    {
        return ContractModel::where('number', $number)->first();
    }

    public function isPublished($contract_model): bool
    {
        return ! is_null($contract_model->getPublishedAt());
    }

    public function make(): ContractModelEntityInterface
    {
        return new ContractModel;
    }
}
