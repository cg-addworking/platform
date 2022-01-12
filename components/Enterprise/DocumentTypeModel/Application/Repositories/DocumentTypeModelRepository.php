<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelCreationFailedException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;
use Illuminate\Support\Str;

class DocumentTypeModelRepository implements DocumentTypeModelRepositoryInterface
{
    public function make(): DocumentTypeModelEntityInterface
    {
        return new DocumentTypeModel;
    }

    public function save(DocumentTypeModelEntityInterface $document_type_model)
    {
        try {
            $document_type_model->save();
        } catch (DocumentTypeModelCreationFailedException $exception) {
            throw $exception;
        }

        $document_type_model->refresh();

        return $document_type_model;
    }

    public function find(string $id)
    {
        return DocumentTypeModel::where('id', $id)->first();
    }

    public function list(DocumentType $document_type)
    {
        return DocumentTypeModel::query()
            ->whereHas('documentType', function ($query) use ($document_type) {
                $query->where('id', $document_type->id);
            })->paginate(25);
    }

    public function delete(DocumentTypeModel $document_type_model)
    {
        return $document_type_model->delete();
    }

    public function checkIfModelHasVariable(DocumentTypeModelEntityInterface $document_type_model)
    {
        return $document_type_model->getVariables()->count() > 0;
    }

    public function findByShortId(string $short_id): ?DocumentTypeModelEntityInterface
    {
        return DocumentTypeModel::where('short_id', $short_id)->first();
    }

    public function isPublished($document_type_model): bool
    {
        return ! is_null($document_type_model->published_at);
    }

    public function transformVariableToSnakeFormat(string $content)
    {
        $pattern = "#\{\{\s*(.*?)\s*\}\}#";

        if (preg_match_all($pattern, $content, $matches)) {
            foreach ($matches[1] as $variable) {
                $variable = trim($variable);
                $content = str_replace($variable, Str::slug($variable, '_'), $content);
            }
        }

        return $content;
    }
}
