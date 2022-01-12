<?php

namespace Components\Mission\Mission\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Illuminate\Http\Request;

class MissionAjaxController extends Controller
{
    public function getWorkfieldsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $workfields = WorkField::whereHas('owner', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            })->latest()->pluck('display_name', 'id');

            $response = [
                'status' => 200,
                'data' => $workfields,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getReferentsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $referents = $enterprise->users()->orderBy('lastname', 'asc')->get()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $referents,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getVendorsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $vendors = $enterprise->vendors()->orderBy('name', 'asc')->get()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $vendors,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
