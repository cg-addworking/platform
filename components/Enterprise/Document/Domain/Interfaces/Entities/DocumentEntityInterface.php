<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Entities;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;

interface DocumentEntityInterface
{
    const STATUS_PENDING_SIGNATURE = 'pending_signature';
    const STATUS_REFUSED_SIGNATURE = 'refused_signature';

    const STATUS_PENDING   = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_OUTDATED  = 'outdated';

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setEnterprise(Enterprise $enterprise);
    public function setDocumentTypeModel(DocumentTypeModelEntityInterface $document_type_model);
    public function setDocumentType($document_type);
    public function setFiles($files);
    public function setSignedBy($signed_by);
    public function setStatus(string $status);
    public function setValidFrom($date);
    public function setValidUntil($date);
    public function setSignedAt($signed_at);
    public function setIsPreCheck(bool $is_pre_check);
    public function setYousignFileId(string $yousign_file_id);
    public function setYousignProcedureId(string $yousign_procedure_id);
    public function setYousignMemberId(string $yousign_member_id);
    public function setRequiredDocument(File $file);
    public function setSignatoryName(?string $signatory_name);

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    public function getSignedBy();
    public function getEnterprise();
    public function getDocumentTypeModel();
    public function getDocumentType();
    public function getId(): string;
    public function getYousignMemberId(): string;
    public function getYousignFileId(): string;
    public function getRequiredDocument(): ?File;
    public function getSignatoryName(): ?string;
    public function getSignedAt();
}
