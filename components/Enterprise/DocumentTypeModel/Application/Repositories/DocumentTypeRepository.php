<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeRepositoryInterface;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name)
    {
        return DocumentType::where('display_name', $display_name)->first();
    }
}
