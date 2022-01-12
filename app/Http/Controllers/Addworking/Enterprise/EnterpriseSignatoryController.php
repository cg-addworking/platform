<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Requests\Addworking\Enterprise\SaveEnterpriseSignatoryRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Http\Controllers\Controller;

class EnterpriseSignatoryController extends Controller
{
    public function save(SaveEnterpriseSignatoryRequest $request)
    {
        $enterprise = Enterprise::findOrFail($request->input('enterprise.id'));
        $signatory  = User::findOrFail($request->input('signatory.id'));

        $saved = transaction(function () use ($enterprise, $signatory) {
            return $enterprise->users()->updateExistingPivot($signatory->id, ['is_signatory' => true]);
        });

        return redirect_when($saved, $enterprise->routes->show);
    }
}
