<?php

namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(string $id)
    {
        return Enterprise::where('id', $id)->first();
    }

    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function findByName(string $name)
    {
        return Enterprise::where('name', $name)->first();
    }

    public function isCustomer(Enterprise $enterprise): bool
    {
        return $enterprise->is_customer;
    }

    public function hasPartnershipWith(Enterprise $customer, Enterprise $vendor): bool
    {
        return $customer->vendors()->where('id', $vendor->id)->exists();
    }

    public function hasCustomManagementFeesTag(Enterprise $customer, Enterprise $vendor): bool
    {
        return $customer->vendors()
            ->wherePivot('custom_management_fees_tag', true)
            ->wherePivot('vendor_id', $vendor->id)
            ->exists();
    }

    public function getActiveVendors(Enterprise $customer, string $month)
    {
        $vendors = $customer->vendors()->get();

        return $vendors->filter(function ($vendor) use ($month) {
            $date = Carbon::createFromFormat('m/Y', $month);

            if (is_null($vendor->pivot->activity_starts_at)) {
                return false;
            }

            if ($date->endOfMonth()->gte($vendor->pivot->activity_starts_at)
                && is_null($vendor->pivot->activity_ends_at)
            ) {
                return true;
            }

            if ($date->endOfMonth()->gte($vendor->pivot->activity_starts_at)
                && $date->startOfMonth()->lte($vendor->pivot->activity_ends_at)
            ) {
                return true;
            }
        });
    }
}
