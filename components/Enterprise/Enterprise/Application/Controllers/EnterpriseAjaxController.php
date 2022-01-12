<?php

namespace Components\Enterprise\Enterprise\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Http\Request;

class EnterpriseAjaxController extends Controller
{
    public function setMemberJobTitle(Request $request)
    {
        $request->validate([
            'member_job_title' => 'required',
            'enterprise_id'    => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();

            $enterprise->users()->updateExistingPivot(
                $request->user(),
                ['job_title' => $request->get('member_job_title')]
            );

            $response = [
                'status' => 200,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
