<?php

namespace Components\Mission\Offer\Application\Models\Scopes;

use Illuminate\Support\Arr;

trait ResponseScope
{
    public function scopeFilterStatus($query, $statuses)
    {
        return $query->whereIn('status', Arr::wrap($statuses));
    }
}
