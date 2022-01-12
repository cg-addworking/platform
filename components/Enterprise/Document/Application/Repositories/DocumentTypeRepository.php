<?php

namespace Components\Enterprise\Document\Application\Repositories;

use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name): ?DocumentTypeEntityInterface
    {
        return DocumentType::where('display_name', $display_name)->first();
    }
}
