<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;

interface ContractModelRepositoryInterface
{
    public function find(string $id): ?ContractModelEntityInterface;
    public function make($data = []): ContractModelEntityInterface;
    public function save(ContractModelEntityInterface $contract_model);
    public function replicate(ContractModelEntityInterface $model);
    public function isPublished($contract_model): bool;
    public function isArchived($contract_model): bool;
    public function findByNumber(string $number): ?ContractModelEntityInterface;
    public function list(?array $filter = null, ?string $search = null);
    public function delete(ContractModelEntityInterface $contract_model): bool;
    public function isDeleted(string $number): bool;
    public function isDraft(ContractModelEntityInterface $contract_model): bool;
    public function getEnterpriseAndChildren(ContractModelEntityInterface $contract_model);
    public function checkIfModelAttachedToContract(ContractModelEntityInterface $contract_model);
    public function getAvailableStatuses(bool $trans = false): array;
    public function getSearchableAttributes(): array;
    public function getAllPublishedContractModels();
}
