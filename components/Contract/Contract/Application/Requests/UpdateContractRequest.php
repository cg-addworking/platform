<?php

namespace Components\Contract\Contract\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract.name' => "required|max:255",
            'contract.valid_from' => "nullable|date",
            'contract.valid_until' => "nullable|date|after_or_equal:contract.valid_from",
            'contract.external_identifier' => "max:255",
        ];
    }
}
