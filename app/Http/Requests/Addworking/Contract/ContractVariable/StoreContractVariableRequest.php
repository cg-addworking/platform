<?php

namespace App\Http\Requests\Addworking\Contract\ContractVariable;

use App\Models\Addworking\Contract\ContractVariable;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractVariableRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractVariable::class, $this->route('contract')]);
    }

    public function rules()
    {
        $contract_template_variable_table = (new ContractVariable)->contractTemplateVariable->getTable();

        return [
            'contract_template_variable.id' => "required|uuid|exists:{$contract_template_variable_table},id",
            'value' => "required|string|max:255",
        ];
    }
}
