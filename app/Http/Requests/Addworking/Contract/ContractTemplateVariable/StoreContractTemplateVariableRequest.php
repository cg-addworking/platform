<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateVariable;

use App\Models\Addworking\Contract\ContractTemplateVariable;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplateVariableRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractTemplateVariable::class, $this->route('contract_template')]);
    }

    public function rules()
    {
        return [
            'contract_template_variable.name'          => "required|string|max:255",
            'contract_template_variable.description'   => "string|max:255",
            'contract_template_variable.default_value' => "string|max:255",
            'contract_template_variable.required'      => "sometimes",
        ];
    }
}
