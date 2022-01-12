<?php

namespace Components\Contract\Contract\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmendmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract.name' => "required|max:255",
            'contract.contract_model' => "nullable|uuid|exists:addworking_contract_contract_models,id",
            'contract.valid_from' => "nullable|date",
            'contract.valid_until' => "nullable|date|after_or_equal:contract.valid_from",
            'contract_part.display_name' => 'required_without:contract.contract_model',
            'contract_party.*.signatory_id' => "required",
        ];
    }
}
