<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseReferentRepository;
use Illuminate\Http\Request;

class EnterpriseReferentController extends Controller
{
    protected $repository;

    public function __construct(EnterpriseReferentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function editAssignedVendors(Request $request, Enterprise $enterprise, User $user)
    {
        $this->authorize('assignVendors', $enterprise);

        return view('addworking.enterprise.referent.edit_assigned_vendors', compact('enterprise', 'user'));
    }

    public function updateAssignedVendors(Request $request, Enterprise $enterprise, User $user)
    {
        $this->authorize('assignVendors', $enterprise);

        $updated = $this->repository->updateAssignedVendorsFromRequest($request, $enterprise, $user);


        return redirect()->back()->with(
            $updated
                ? success_status(__('enterprise.enterprise.referent_vendors_updated_ok'))
                : error_status(__('enterprise.enterprise.referent_vendors_updated_nok'))
        );
    }
}
