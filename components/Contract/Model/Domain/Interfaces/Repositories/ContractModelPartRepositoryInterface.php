<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;

interface ContractModelPartRepositoryInterface
{
    public function make($data = []): ContractModelPartEntityInterface;
    public function save(ContractModelPartEntityInterface $contract_model_part);
    public function createFile($content, bool $html = false);
    public function list(ContractModelEntityInterface $contract_model, ?array $filter = null, ?string $search = null);
    public function findByNumber(int $number): ?ContractModelPartEntityInterface;
    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartEntityInterface;
    public function delete(ContractModelPartEntityInterface $contract_model_part): bool;
    public function findByContractModelWithFiles(ContractModelEntityInterface $contract_model);
    public function generate(ContractModelPartEntityInterface $contract_model_part);
    public function download(ContractModelPartEntityInterface $contract_model_part);
    public function createFileFromPdf(ContractModelPartEntityInterface $contract_model_part);
    public function formatTextForPdf(string $text): string;
}
