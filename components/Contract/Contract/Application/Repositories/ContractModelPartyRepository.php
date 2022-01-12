<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelParty;

class ContractModelPartyRepository implements ContractModelPartyRepositoryInterface
{
    public function make($data = []): ContractModelPartyEntityInterface
    {
        return new ContractModelParty($data);
    }

    public function find(string $id): ?ContractModelPartyEntityInterface
    {
        return ContractModelParty::where('id', $id)->first();
    }

    public function findByNumber(int $number): ?ContractModelPartyEntityInterface
    {
        return ContractModelParty::where('number', $number)->first();
    }

    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartyEntityInterface {
        return ContractModelParty::where('order', $order)
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })->first();
    }
}
