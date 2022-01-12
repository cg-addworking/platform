<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\BillingEnterpriseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorsBillingDeadlinesController extends Controller
{
    public function index(Enterprise $enterprise, Enterprise $vendor)
    {
        $this->authorize('viewAnyBillingDeadlineVendor', [$enterprise, $vendor]);

        $items = app(BillingEnterpriseRepository::class)->getAvailableDeadlinesForCustomer($vendor, $enterprise);

        return view(
            'addworking.enterprise.vendor.billing_deadline.index',
            @compact('enterprise', 'vendor', 'items')
        );
    }

    public function edit(Enterprise $enterprise, Enterprise $vendor)
    {
        $this->authorize('editBillingDeadlineVendor', [$enterprise, $vendor]);

        $vendor_deadlines = app(BillingEnterpriseRepository::class)
            ->getAvailableDeadlinesForCustomer($vendor, $enterprise);

        return view(
            'addworking.enterprise.vendor.billing_deadline.edit',
            @compact('enterprise', 'vendor', 'vendor_deadlines')
        );
    }

    public function update(Request $request, Enterprise $enterprise, Enterprise $vendor)
    {
        $this->authorize('updateBillingDeadlineVendor', [$enterprise, $vendor]);
        $array = [];

        if ($request->has('deadline_type')) {
            foreach ($request->input('deadline_type') as $deadline) {
                $array[$deadline] = ['customer_id' => $enterprise->id];
            }
        }

        $vendor->authorizedDeadlineForVendor()->wherePivot('customer_id', $enterprise->id)->sync($array);

        return $this->redirectWhen(
            true,
            route('addworking.enterprise.vendor.billing_deadline.index', @compact('enterprise', 'vendor'))
        );
    }
}
