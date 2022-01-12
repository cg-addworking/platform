<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateVariable;

use App\Models\Addworking\Contract\ContractTemplateVariable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTemplateVariableRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_template_variable'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
