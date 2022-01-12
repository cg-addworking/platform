<?php

namespace Components\Enterprise\Resource\Application\Models\Concerns;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Support\Facades\DB;

trait ResourceScopes
{
    public function scopeSearch($query, string $search)
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterStatus($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeOfVendor($query, Enterprise $enterprise)
    {
        return $query->whereHas('vendor', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeFilterNumber($query, $number)
    {
        return $query->where('number', 'LIKE', "%{$number}%");
    }

    public function scopeFilterLastName($query, $last_name)
    {
        return $query->where(DB::raw('LOWER(last_name)'), 'LIKE', "%". strtolower($last_name)."%");
    }

    public function scopeFilterFirstName($query, $first_name)
    {
        return $query->where(DB::raw('LOWER(first_name)'), 'LIKE', "%". strtolower($first_name)."%");
    }

    public function scopeFilterEmail($query, $email)
    {
        return $query->where(DB::raw('LOWER(email)'), 'like', "%". strtolower($email)."%");
    }

    public function scopeFilterRegistrationNumber($query, $registration_number)
    {
        return $query->where(DB::raw('LOWER(registration_number)'), 'like', "%". strtolower($registration_number)."%");
    }
}
