<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractModelPartRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'contract_model_part.signature_page' => 'required_if:contract_model_part.is_signed,==,1|integer|min:1',
            'contract_model_part.is_signed'      => 'required|boolean',
            'contract_model_part.is_initialled'  => 'required|boolean',
            'contract_model_part.order'          => 'required|integer',
            'contract_model_part.display_name'   => 'required|string|max:255',
        ];

        $contract_model_part = $this->route('contract_model_part');

        if ($contract_model_part->getShouldCompile()) {
            $rules['contract_model_part.textarea'] = "required|string";
        } else {
            $rules['contract_model_part.file'] = "nullable|file|min:1|max:4000|mimes:pdf";
        }

        return $rules;
    }
}
