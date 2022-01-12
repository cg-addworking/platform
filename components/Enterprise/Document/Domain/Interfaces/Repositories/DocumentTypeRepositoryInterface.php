<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Repositories;

use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;

interface DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name): ?DocumentTypeEntityInterface;
}
