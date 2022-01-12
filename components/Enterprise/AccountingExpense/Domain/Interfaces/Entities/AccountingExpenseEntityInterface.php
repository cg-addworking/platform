<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;

interface AccountingExpenseEntityInterface
{
    const SEARCHABLE_ATTRIBUTE_DISPLAY_NAME = 'display_name';
    const SEARCHABLE_ATTRIBUTE_ANALYTICAL_CODE = 'analytical_code';

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;
    public function setEnterprise(Enterprise $enterprise): void;
    public function setName(string $display_name): void;
    public function setDisplayName(string $display_name): void;
    public function setAnalyticalCode(?string $analytical_code): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string;
    public function getNumber(): int;
    public function getEnterprise(): Enterprise;
    public function getName(): string;
    public function getDisplayName(): ?string;
    public function getAnalyticalCode(): ?string;
    public function getMissionTrackingLines();
}
