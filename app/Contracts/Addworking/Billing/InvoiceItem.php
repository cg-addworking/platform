<?php

namespace App\Contracts\Addworking\Billing;

interface InvoiceItem
{
    public function getAmountBeforeTaxes(): float;

    public function getAmountOfTaxes(): float;

    public function getAmountAllTaxesIncluded(): float;
}
