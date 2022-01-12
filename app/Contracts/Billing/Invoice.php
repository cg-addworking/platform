<?php

namespace App\Contracts\Billing;

interface Invoice
{
    const STATUS_TO_VALIDATE    = 'to_validate';
    const STATUS_PENDING        = 'pending';
    const STATUS_VALIDATED      = 'validated';
    const STATUS_PAID           = 'paid';

    const DEADLINE_UPON_RECEIPT = "upon_receipt";
    const DEADLINE_30_DAYS      = "30_days";
    const DEADLINE_40_DAYS      = "40_days";

    public function getAmountAttribute(): float;

    public function getAmountOfTaxesAttribute(): float;

    public function getAmountAllTaxesIncludedAttribute(): float;

    public static function getStatuses(): array;
}
