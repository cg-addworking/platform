<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface;

interface DocumentTypeRepositoryInterface
{
    public function findByDisplayName(string $display_name);
}
