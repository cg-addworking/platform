<?php

namespace App\Contracts\Models;

interface Searchable
{
    public function scopeSearch($query, string $search);
}
