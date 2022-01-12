<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractModelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_model.display_name' => "required|max:255",
            'contract_model.enterprise'   => "required|uuid|exists:addworking_enterprise_enterprises,id",
            'contract_model.parties.*'     => "required|max:255",
        ];
    }
}
