<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;

interface ContractStateRepositoryInterface
{
    public function updateContractState(ContractEntityInterface $contract): ContractEntityInterface;
    public function getState(ContractEntityInterface $contract): string;
    public function isCanceled(ContractEntityInterface $contract): bool;
    public function isInactive(ContractEntityInterface $contract): bool;
    public function isDue(ContractEntityInterface $contract): bool;
    public function isActive(ContractEntityInterface $contract): bool;
    public function isSigned(ContractEntityInterface $contract): bool;
    public function toSign(ContractEntityInterface $contract): bool;
    public function generated(ContractEntityInterface $contract): bool;
    public function isReadyToGenerate(ContractEntityInterface $contract): bool;
    public function isInPreparation(ContractEntityInterface $contract): bool;
    public function isMissingDocuments(ContractEntityInterface $contract): bool;
    public function isDraft(ContractEntityInterface $contract): bool;
    public function isArchived(ContractEntityInterface $contract): bool;
}
