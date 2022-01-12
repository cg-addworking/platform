<?php

namespace Components\Enterprise\Document\Application\Repositories;

use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeRejectReasonCreationFailedException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeRejectReasonEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;

class DocumentTypeRejectReasonRepository implements DocumentTypeRejectReasonRepositoryInterface
{
    public function make(): DocumentTypeRejectReasonEntityInterface
    {
        return new DocumentTypeRejectReason();
    }

    public function find($id): ?DocumentTypeRejectReasonEntityInterface
    {
        return DocumentTypeRejectReason::find($id);
    }

    public function save(DocumentTypeRejectReasonEntityInterface $document_type_reject_reason)
    {
        try {
            $document_type_reject_reason->save();
        } catch (DocumentTypeRejectReasonCreationFailedException $exception) {
            throw $exception;
        }

        $document_type_reject_reason->refresh();

        return $document_type_reject_reason;
    }

    public function delete(DocumentTypeRejectReasonEntityInterface $document_type_reject_reason)
    {
        return $document_type_reject_reason->delete();
    }

    public function findByNumber(String $number): ?DocumentTypeRejectReasonEntityInterface
    {
        return DocumentTypeRejectReason::where('number', $number)->first();
    }

    public function list(DocumentTypeEntityInterface $document_type, ?int $page = null)
    {
        return DocumentTypeRejectReason::query()
            ->whereHas('documentType', function ($q) use ($document_type) {
                $q->where('id', $document_type->getId());
            })
            ->orWhereDoesntHave('documentType')
            ->orderBy('created_at')
            ->paginate($page ?? 25);
    }

    public function listRejectReason($document_type)
    {
        return  DocumentTypeRejectReason::query()
            ->whereHas('documentType', function ($q) use ($document_type) {
                $q->where('id', $document_type->id);
            })
            ->orWhereDoesntHave('documentType')
            ->orderBy('created_at')
            ->pluck('display_name', 'id');
    }

    public function isUniversal(DocumentTypeRejectReasonEntityInterface $document_type_reject_reason): bool
    {
        return is_null($document_type_reject_reason->getDocumentType());
    }
}
