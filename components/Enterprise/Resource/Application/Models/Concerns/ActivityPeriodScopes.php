<?php

namespace Components\Enterprise\Resource\Application\Models\Concerns;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Support\Facades\DB;

trait ActivityPeriodScopes
{
    public function scopeSearch($query, string $search)
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterVendor($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterLastName($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterFirstName($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterEmail($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeOfCustomer($query, Enterprise $customer)
    {
        return $query->where('customer_id', $customer->id);
    }

    public function scopeFilterVendor($query, $vendor)
    {
        return $query->whereHas('resource', function ($query) use ($vendor) {
            $query->whereHas('vendor', function ($query) use ($vendor) {
                $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($vendor)."%");
            });
        });
    }

    public function scopeFilterLastName($query, $last_name)
    {
        return $query->whereHas('resource', function ($query) use ($last_name) {
            $query->whereHas('vendor', function ($query) use ($last_name) {
                return $query->where(DB::raw('LOWER(last_name)'), 'LIKE', "%". strtolower($last_name)."%");
            });
        });
    }

    public function scopeFilterFirstName($query, $first_name)
    {
        return $query->whereHas('resource', function ($query) use ($first_name) {
            $query->whereHas('vendor', function ($query) use ($first_name) {
                return $query->where(DB::raw('LOWER(first_name)'), 'LIKE', "%". strtolower($first_name)."%");
            });
        });
    }

    public function scopeFilterEmail($query, $email)
    {
        return $query->whereHas('resource', function ($query) use ($email) {
            $query->whereHas('vendor', function ($query) use ($email) {
                return $query->where(DB::raw('LOWER(email)'), 'like', "%". strtolower($email)."%");
            });
        });
    }
}
