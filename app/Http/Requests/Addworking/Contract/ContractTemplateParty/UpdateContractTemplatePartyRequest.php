<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateParty;

use App\Models\Addworking\Contract\ContractTemplateParty;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTemplatePartyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_template_party'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
