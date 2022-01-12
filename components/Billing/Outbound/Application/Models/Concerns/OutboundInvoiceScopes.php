<?php

namespace Components\Billing\Outbound\Application\Models\Concerns;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Support\Facades\DB;

trait OutboundInvoiceScopes
{
    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeFilterInvoicedAt($query, $date)
    {
        return $query->where('invoiced_at', 'LIKE', "%{$date}%");
    }

    public function scopeFilterDueAt($query, $date)
    {
        return $query->where('due_at', 'LIKE', "%{$date}%");
    }

    public function scopeFilterEnterprise($query, string $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where(DB::raw('LOWER(name)'), 'LIKE', "%". strtolower($enterprise)."%");
        });
    }

    public function scopeFilterNumber($query, $number)
    {
        return $query->where('number', 'LIKE', "%{$number}%");
    }

    public function scopeFilterMonth($query, $month)
    {
        return $query->where('month', 'LIKE', "%{$month}%");
    }

    public function scopeFilterDeadline($query, string $deadline)
    {
        return $query->whereHas('deadline', function ($query) use ($deadline) {
            $query->where(DB::raw('LOWER(name)'), strtolower($deadline));
        });
    }

    public function scopeSearch($query, string $search)
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterEnterprise($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterNumber($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }
}
