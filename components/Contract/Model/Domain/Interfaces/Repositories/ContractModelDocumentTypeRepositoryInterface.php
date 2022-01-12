<?php
namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelDocumentTypeEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

interface ContractModelDocumentTypeRepositoryInterface
{
    public function make(array $data = []): ContractModelDocumentType;

    public function save(ContractModelDocumentTypeEntityInterface $contract_model_document_type);

    public function getFromContractModelParty(ContractModelPartyEntityInterface $contract_model_party);

    public function findByNumber(int $number): ?ContractModelDocumentType;

    public function delete(ContractModelDocumentTypeEntityInterface $contract_model_document_type): bool;

    public function list(?array $filter, ?string $search, ContractModelPartyEntityInterface $contract_model_party);
}
