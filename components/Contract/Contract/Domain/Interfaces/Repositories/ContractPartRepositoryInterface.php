<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;

interface ContractPartRepositoryInterface
{
    public function make($data = []): ContractPartEntityInterface;
    public function save(ContractPartEntityInterface $contract_part);
    public function createFile($content);
    public function getContractPartsFrom(
        ContractModelPartEntityInterface $contract_model_part,
        ContractEntityInterface $contract
    );
    public function destroy($collection): bool;
    public function findByNumber(string $number);
    public function delete(ContractPartEntityInterface $contract_part): bool;
    public function hasContractModelPart(ContractPartEntityInterface $contract_part): bool;
    public function getPartsWithModel(ContractEntityInterface $contract);
    public function findByOrder(ContractEntityInterface $contract, int $order): ?ContractPartEntityInterface;
    public function isOrderedFirst(ContractPartEntityInterface $contract_part, string $direction): bool;
    public function isOrderedLast(ContractPartEntityInterface $contract_part, string $direction): bool;
    public function createContractPartFromInput(
        ContractEntityInterface $contract,
        array $inputs,
        $file
    ): ContractPartEntityInterface;
}
