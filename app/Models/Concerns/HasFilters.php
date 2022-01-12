<?php

namespace App\Models\Concerns;

use App\Models\Addworking\Contract\Contract;
use Illuminate\Http\Request;

trait HasFilters
{

    protected $fields = [
        'created_at'             => "filterCreatedAt",
        'customer'               => "filterCustomer",
        'deadline'               => "deadline",
        'enterprise'             => "filterEnterprise",
        'legal_representative'   => "ofLegalRepresentative",
        'mime_type'              => "mimeType",
        'month'                  => "month",
        'number'                 => "withNumber",
        'owner'                  => "owner",
        'path'                   => "path",
        'status'                 => "status",
        'type'                   => "ofType",
        'vendor'                 => "filterVendor",
        'updated_at'             => "filterUpdatedAt",
        'name'                   => "name",
        'email'                  => "email",
        'starts_at'              => "filterStartsAt",
        'ends_at'                => "filterEndsAt",
        'customer_enterprise_id' => "customer",
        'vendor_enterprise_id'   => "vendor",
    ];

    public function scopeFilter($query, Request $request)
    {
        return $query->when($request->has('filter'), function ($query) use ($request) {
            foreach ($this->fields as $field => $method) {
                if (! is_null($value = $request->input("filter.{$field}"))) {
                    $query->$method($value);
                }
            }
        });
    }

    /**
     * Filters that are of the given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    /**
     * Filters that are updated of the given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterUpdatedAt($query, $date)
    {
        return $query->where('updated_at', 'like', "%{$date}%");
    }

    /**
     * Filters contracts of the given customer enterprise.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $enterprise
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('customer', function ($query) use ($enterprise) {
            $query->where('name', 'like', "%".strtoupper($enterprise)."%");
        });
    }

    /**
     * Filters contracts of the given vendor enterprise.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $enterprise
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterVendor($query, $enterprise)
    {
        return $query->whereHas('vendor', function ($query) use ($enterprise) {
            $query->where('name', 'like', "%".strtoupper($enterprise)."%");
        });
    }

    /**
     * Filters enterprise of the given enterprise.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $enterprise
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterEnterprise($query, $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('name', 'like', "%".strtoupper($enterprise)."%");
        });
    }

    /**
     * Filters that are of the given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterStartsAt($query, $date)
    {
        return $query->where('starts_at', 'like', "%{$date}%");
    }

    /**
     * Filters that are of the given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterEndsAt($query, $date)
    {
        return $query->where('ends_at', 'like', "%{$date}%");
    }
}
