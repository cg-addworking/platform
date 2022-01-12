<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

interface ContractModelPartyRepositoryInterface
{
    public function make($data = []): ContractModelPartyEntityInterface;
    public function save(ContractModelPartyEntityInterface $contract_model_party);
    public function find(string $id): ContractModelPartyEntityInterface;
    public function delete(ContractModelPartyEntityInterface $contract_model_party): bool;
    public function isDeletable(ContractModelPartyEntityInterface $contract_model_party): bool;
    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartyEntityInterface;
    public function findByNumber(int $number): ?ContractModelPartyEntityInterface;
    public function calculateSignaturePosition(int $order): string;
}
