<?php

namespace Components\Infrastructure\Scopes;

trait StatusScopes
{
    public function scopeFilterStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
