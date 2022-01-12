<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Models\Addworking\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnterpriseReferentRepository implements RepositoryInterface
{
    public function attach(Enterprise $customer, User $user, Enterprise $vendor): bool
    {
        $user->referentVendorsOf($customer)->attach($vendor, [
            'customer_id' => $customer->id,
            'created_by' => Auth::user()->id,
        ]);

        return true;
    }

    public function detach(Enterprise $customer, User $user, Enterprise $vendor): bool
    {
        return $user->referentVendorsOf($customer)->detach($vendor);
    }

    public function sync(Enterprise $customer, User $user, EnterpriseCollection $vendors): bool
    {
        $assigned_vendors = $user->referentVendorsOf($customer)->get();

        $vendors_to_detach = $assigned_vendors->diff($vendors);
        $vendors_to_attach = $vendors->diff($assigned_vendors);

        $vendors_to_detach->each(function ($vendor) use ($user, $customer) {
            $this->detach($customer, $user, $vendor);
        });

        $vendors_to_attach->each(function ($vendor) use ($user, $customer) {
            $this->attach($customer, $user, $vendor);
        });

        return true;
    }

    public function updateAssignedVendorsFromRequest(Request $request, Enterprise $enterprise, User $user): bool
    {
        if (! $request->input('vendors')) {
            $user->referentVendorsOf($enterprise)->detach();
            return true;
        }

        $vendors = new EnterpriseCollection();

        foreach ($request->input('vendors') as $vendor_id) {
            $vendors->push(Enterprise::find($vendor_id));
        }

        return $this->sync($enterprise, $user, $vendors);
    }
}
