<?php

namespace App\Http\Requests\Addworking\Enterprise;

use App\Http\Requests\Addworking\User\User\StoreUserRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;

class ValidateInvitationVendorRequest extends FormRequest
{
    public function rules()
    {
        $host = Enterprise::find($this->get('enterprise'));

        $baseRules = [
            'required',
            'exists:addworking_enterprise_enterprises,id',
            'uuid',
            function ($attribute, $value, $fail) use ($host) {
                if ($host->vendors()->where('vendor_id', $value)->exists()) {
                    $fail("Cette entreprise est déjà connectée en tant que vendor !");
                }
            }
        ];

        return null !== $this->get('user')
            ? (new StoreUserRequest())->rules()
            : ['guest_enterprise' => $baseRules];
    }
}
