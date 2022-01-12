<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name): ?DocumentType
    {
        return DocumentType::where('display_name', $display_name)->first();
    }

    public function findByNameAndEnterprise(string $name, Enterprise $enterprise)
    {
        return DocumentType::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->where('name', $name)->first();
    }
}
