<?php

namespace Components\Infrastructure\Scopes;

trait DateScopes
{
    public function scopeFilterCreatedAt($query, $date)
    {
        return $query->where('created_at', 'LIKE', "%{$date}%");
    }
}
