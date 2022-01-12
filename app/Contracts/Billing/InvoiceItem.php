<?php

namespace App\Contracts\Billing;

interface InvoiceItem
{
    public function invoice();

    public function getAmountAttribute(): float;

    public function getAmountOfTaxesAttribute(): float;

    public function getAmountAllTaxesIncludedAttribute(): float;
}
