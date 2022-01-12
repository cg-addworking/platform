<?php

namespace App\Http\Requests\Addworking\Contract\ContractVariable;

use App\Models\Addworking\Contract\ContractVariable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractVariableRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_variable'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
