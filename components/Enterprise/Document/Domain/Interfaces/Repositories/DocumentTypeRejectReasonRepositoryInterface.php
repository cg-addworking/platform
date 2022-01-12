<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Repositories;

use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeRejectReasonEntityInterface;

interface DocumentTypeRejectReasonRepositoryInterface
{
    public function make(): DocumentTypeRejectReasonEntityInterface;
    public function find($id): ?DocumentTypeRejectReasonEntityInterface;
    public function findByNumber(String $number): ?DocumentTypeRejectReasonEntityInterface;
    public function save(DocumentTypeRejectReasonEntityInterface $document_type_reject_reason);
    public function delete(DocumentTypeRejectReasonEntityInterface $document_type_reject_reason);
    public function list(DocumentTypeEntityInterface $document_type, ?int $page = null);
    public function listRejectReason($document_type);
    public function isUniversal(
        DocumentTypeRejectReasonEntityInterface $document_type_reject_reason
    ): bool;
}
