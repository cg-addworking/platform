<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyInvoicingDetailEntityInterface
{
    public function getVatNumber(): ?string;
    public function getAccountingYearEndDate(): string;
    public function getVatExemption(): bool;
}
