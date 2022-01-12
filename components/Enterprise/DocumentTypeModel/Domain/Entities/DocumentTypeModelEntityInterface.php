<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Entities;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;

interface DocumentTypeModelEntityInterface
{
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setFile(File $file): void;
    public function setDocumentType(DocumentType $document_type): void;
    public function setVariables(DocumentTypeModelVariable $document_type_model_variables): void;
    public function setDisplayName(string $display_name): void;
    public function setName(string $display_name): void;
    public function setContent(string $content): void;
    public function setShortId(): void;
    public function setSignaturePage(int $signature_page): void;
    public function setPublishedAt();
    public function setPublishedBy($user);
    public function setDescription(string $description): void;
    public function setRequiresDocuments(bool $value): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getId(): ?string;
    public function getName(): ?string;
    public function getDisplayName(): ?string;
    public function getDescription(): ?string;
    public function getSignaturePage(): ?int;
    public function getShortId(): int;
    public function getVariables();
    public function getContent(): string;
    public function getDocumentType(): ?DocumentType;
    public function getPublishedAt();
    public function getRequiresDocuments(): ?bool;
}
