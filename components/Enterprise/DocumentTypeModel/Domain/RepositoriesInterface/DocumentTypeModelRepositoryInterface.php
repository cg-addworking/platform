<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface;

use App\Models\Addworking\Enterprise\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;

interface DocumentTypeModelRepositoryInterface
{
    public function make(): DocumentTypeModelEntityInterface;
    public function save(DocumentTypeModelEntityInterface $document_type_model);
    public function list(DocumentType $document_type);
    public function delete(DocumentTypeModel $document_type_model);
    public function findByShortId(string $short_id): ?DocumentTypeModelEntityInterface;
    public function checkIfModelHasVariable(DocumentTypeModelEntityInterface $document_type_model);
    public function isPublished($document_type_model): bool;
}
