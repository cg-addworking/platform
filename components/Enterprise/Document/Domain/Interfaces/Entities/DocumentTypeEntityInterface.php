<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;

interface DocumentTypeEntityInterface
{
    const TYPE_LEGAL       = 'legal';
    const TYPE_BUSINESS    = 'business';
    const TYPE_INFORMATIVE = 'informative';
    const TYPE_CONTRACTUAL  = 'contractual';

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string;
    public function getEnterprise();
    public function getName(): ?string;
    public function getDeadlineDate();

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDisplayName(string $display_name): void;
    public function setEnterprise(Enterprise $enterprise): void;
    public function setDocumentTypeModels(array $document_type_models): void;
    public function setName(string $name): void;
    public function setDeadlineDate($deadline_date): void;
}
