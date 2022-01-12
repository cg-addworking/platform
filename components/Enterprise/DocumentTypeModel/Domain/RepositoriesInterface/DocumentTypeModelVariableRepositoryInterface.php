<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface;

use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelVariableEntityInterface;
use Illuminate\Support\Collection;

interface DocumentTypeModelVariableRepositoryInterface
{
    public function make(): DocumentTypeModelVariableEntityInterface;
    public function save(DocumentTypeModelVariableEntityInterface $contract_model_variable);
    public function find(string $id);
    public function findVariables(string $content): array;
    public function setVariable(string $variable, DocumentTypeModelEntityInterface $document_type_model);
    public function variableExists(DocumentTypeModelEntityInterface $document_type_model, string $name);
    public function delete(DocumentTypeModelVariableEntityInterface $document_type_model_variable): bool;
    public function getAvailableInputTypes(bool $trans = false): array;
    public function findByShortId(int $short_id): ?DocumentTypeModelVariableEntityInterface;
}
