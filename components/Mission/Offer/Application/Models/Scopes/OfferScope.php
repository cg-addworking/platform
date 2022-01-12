<?php

namespace Components\Mission\Offer\Application\Models\Scopes;

use Illuminate\Support\Arr;

trait OfferScope
{
    public function scopeFilterStatus($query, $statuses)
    {
        return $query->whereIn('status', Arr::wrap($statuses));
    }
}
