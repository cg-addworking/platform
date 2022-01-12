<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

interface DocumentTypeRepositoryInterface
{
    public function find(string $id): ?DocumentType;

    public function getFromEnterpriseExcludeThoseInContractModelParty(
        Enterprise $enterprise,
        ContractModelPartyEntityInterface $party
    );

    public function findByDisplayName(string $display_name): ?DocumentType;
}
