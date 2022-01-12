<?php

namespace Components\Contract\Contract\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractPartRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'contract_part.signature_page' => 'required_without:contract_part.sign_on_last_page',
        ];
        return $rules;
    }
}
