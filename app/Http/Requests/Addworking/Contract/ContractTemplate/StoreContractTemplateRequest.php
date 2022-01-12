<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplate;

use App\Models\Addworking\Contract\ContractTemplate;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractTemplate::class, $this->route('enterprise')]);
    }

    public function rules()
    {
        return [
            'contract_template.display_name' =>  "required|string",
        ];
    }
}
