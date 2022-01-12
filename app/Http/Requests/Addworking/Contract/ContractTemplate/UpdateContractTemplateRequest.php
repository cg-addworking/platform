<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplate;

use App\Models\Addworking\Contract\ContractTemplate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTemplateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_template.display_name' =>  "required|string",
        ];
    }
}
