<?php

namespace App\Http\Requests\Addworking\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorInvitationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'emails' => 'array|required'
        ];
    }

    public function prepareForValidation()
    {
        if (!is_array($this->get('emails'))) {
            $this->merge(['emails' => explode_trim("\n", $this->get('emails'), 'strtolower')]);
        }
    }
}
