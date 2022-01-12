<?php

namespace App\Models\Addworking\Billing;

use App\Contracts\Addworking\Billing\InvoiceItem;
use Illuminate\Database\Eloquent\Collection;

class InvoiceItemCollection extends Collection implements InvoiceItem
{
    public function getAmountBeforeTaxes(): float
    {
        return round($this->reduce(function ($carry, InvoiceItem $item) {
            return $carry + $item->getAmountBeforeTaxes();
        }, 0), 2);
    }

    public function getAmountOfTaxes(): float
    {
        return round($this->reduce(function ($carry, InvoiceItem $item) {
            return $carry + $item->getAmountOfTaxes();
        }, 0), 2);
    }

    public function getAmountAllTaxesIncluded(): float
    {
        return $this->getAmountBeforeTaxes() + $this->getAmountOfTaxes();
    }
}
