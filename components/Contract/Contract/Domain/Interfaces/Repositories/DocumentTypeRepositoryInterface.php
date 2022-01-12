<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;

interface DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name): ?DocumentType;
    public function findByNameAndEnterprise(string $name, Enterprise $enterprise);
}
