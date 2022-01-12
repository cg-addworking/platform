<?php

namespace Components\Mission\Mission\Application\Models\Scopes;

use App\Models\Addworking\Enterprise\Enterprise;

trait MissionScope
{
    public function scopeOfVendor($query, Enterprise $enterprise)
    {
        return $query->where('vendor_enterprise_id', $enterprise->id);
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->where('customer_enterprise_id', $enterprise->id);
    }
}
