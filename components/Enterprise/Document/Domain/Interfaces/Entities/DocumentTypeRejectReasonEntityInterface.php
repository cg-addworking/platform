<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Entities;

interface DocumentTypeRejectReasonEntityInterface
{
    public function setDocumentType($document_type): void;
    public function setNumber(): void;
    public function setName(string $name): void;
    public function setDisplayName(string $display_name): void;
    public function setMessage(string $message): void;
    public function setDeletedAt($deleted_at): void;
    public function getDocumentType(): ?DocumentTypeEntityInterface;
    public function getId(): string;
    public function getNumber(): ?int;
    public function getName(): ?string;
    public function getDisplayName(): ?string;
    public function getMessage(): ?string;
    public function getDeletedAt();
    public function getCreatedAt();
    public function getUpdatedAt();
}
