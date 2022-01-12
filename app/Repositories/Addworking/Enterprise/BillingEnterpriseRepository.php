<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;

class BillingEnterpriseRepository implements RepositoryInterface
{
    public function isUnderTrial(Enterprise $enterprise, $date = null): bool
    {
        return $enterprise->outboundInvoiceParameters->trial_ends_at->gte($date ?: Carbon::now());
    }

    public function getAvailableDeadlinesForCustomer(Enterprise $vendor, Enterprise $customer)
    {
        return $vendor->authorizedDeadlineForVendor()
            ->wherePivot('customer_id', $customer->id)
            ->get();
    }
}
