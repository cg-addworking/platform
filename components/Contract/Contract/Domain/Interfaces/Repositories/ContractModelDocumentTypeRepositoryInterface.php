<?php
namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;

interface ContractModelDocumentTypeRepositoryInterface
{
    public function make(array $data = []): ContractModelDocumentType;
    public function list(ContractPartyEntityInterface $contract_party, ?array $filter = null, ?string $search = null);
}
