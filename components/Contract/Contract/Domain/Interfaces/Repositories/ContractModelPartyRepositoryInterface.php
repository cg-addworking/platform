<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

interface ContractModelPartyRepositoryInterface
{
    public function make($data = []): ContractModelPartyEntityInterface;
    public function find(string $id): ?ContractModelPartyEntityInterface;
    public function findByNumber(int $number): ?ContractModelPartyEntityInterface;
    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartyEntityInterface;
}
