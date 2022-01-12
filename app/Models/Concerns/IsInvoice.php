<?php

namespace App\Models\Concerns;

use App\Contracts\Billing\Invoice;
use UnexpectedValueException;
use RuntimeException;

trait IsInvoice
{
    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    abstract public function items();

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getAmountAttribute(): float
    {
        return $this->items->reduce(function ($carry, $item) {
            return $carry + $item->amount_before_taxes;
        }) ?? 0;
    }

    public function getAmountOfTaxesAttribute(): float
    {
        return $this->items->reduce(function ($carry, $item) {
            return $carry + $item->amount_of_taxes;
        }) ?? 0;
    }

    public function getAmountAllTaxesIncludedAttribute(): float
    {
        return $this->getAmountAttribute() + $this->getAmountOfTaxesAttribute();
    }

    public function setStatus($value)
    {
        if (!in_array($value, static::getStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    /**
     * @deprecated v0.5.59 remove this!
     */
    public function setDateAttribute($value)
    {
        throw new RuntimeException("deprecated");
    }

    /**
     * @deprecated v0.5.59 remove this!
     */
    public function getDateAttribute()
    {
        throw new RuntimeException("deprecated");
    }

    public function setStatusAttribute($value)
    {
        if (!in_array($value, static::getStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = $value;
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeExceptToValidate($query)
    {
        return $query->where('status', '!=', self::STATUS_TO_VALIDATE);
    }

    public function scopeExceptPending($query)
    {
        return $query->where('status', '!=', self::STATUS_PENDING);
    }

    public function scopeExceptValidated($query)
    {
        return $query->where('status', '!=', self::STATUS_VALIDATED);
    }

    public function scopeExceptPaid($query)
    {
        return $query->where('status', '!=', self::STATUS_PAID);
    }

    public function scopeValidated($query)
    {
        return $query->where('status', self::STATUS_VALIDATED);
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public static function getStatuses(): array
    {
        return [
            Invoice::STATUS_TO_VALIDATE,
            Invoice::STATUS_PENDING,
            Invoice::STATUS_VALIDATED,
            Invoice::STATUS_PAID,
        ];
    }

    public function getFilePath($ext): string
    {
        list($month, $year) = explode('/', $this->month);

        return sprintf(
            "/enterprises/%s/invoices/%s-%s/%s_invoice_%s.%s",
            $this->enterprise->id,
            $year,
            $month,
            $this->id,
            $this->number,
            $ext
        );
    }
}
