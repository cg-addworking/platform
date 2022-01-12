<?php

namespace Components\Common\Common\Application\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LazyLoadingController extends Controller
{
    public function loadActionHtml(Request $request)
    {
        $request->validate([
           'action_path' => 'required|string',
           'action_objects' => 'required',
        ]);

        if ($request->ajax()) {
            $action_path = $request->input('action_path');
            $objects = json_decode($request->input('action_objects'));
            $action_blade_params = [];
            foreach ($objects as $object_name => $object_data) {
                $object = ($object_data->model)::find($object_data->id);
                $action_blade_params[$object_name] = $object;
            }

            $response = [
                'status' => 200,
                'data' => [
                    'action_html' => view($action_path, $action_blade_params)->render()
                ],
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
