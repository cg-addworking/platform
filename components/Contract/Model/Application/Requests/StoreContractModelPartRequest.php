<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractModelPartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_model_part.file' =>
                "required_without:contract_model_part.textarea|file|min:1|max:4000|mimes:pdf",
            'contract_model_part.textarea' => "sometimes|required|string",
            'contract_model_part.is_signed' => "required|boolean",
            'contract_model_part.signature_page' => 'required_without:sign_on_last_page|integer|min:1',
            'contract_model_part.is_initialled' => "required|boolean",
            'contract_model_part.order' => "required|integer",
            'contract_model_part.display_name' => "required|string|max:255",
        ];
    }
}
