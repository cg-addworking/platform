<?php

namespace Components\Enterprise\InvoiceParameter\Application\Models\Scopes;

use Carbon\Carbon;

trait InvoiceParameterScope
{
    public function scopeIsActive($query)
    {
        $now = Carbon::now();
        return $query->where('starts_at', '<=', $now)->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
    }

    public function scopeIsActiveInPeriod($query, string $month)
    {
        $date = Carbon::createFromFormat('m/Y', $month);
        return $query
            ->where('starts_at', '<=', $date->endOfMonth())
            ->whereNull('ends_at')->orWhere('ends_at', '>=', $date->startOfMonth());
    }
}
