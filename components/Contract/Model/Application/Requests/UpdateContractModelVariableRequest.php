<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractModelVariableRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_model_variable.*.description' => 'nullable',
            'contract_model_variable.*.default_value' => 'nullable|contract_model_variable_size',
            'contract_model_variable.*.options.*' => 'max:255',
        ];
    }
}
