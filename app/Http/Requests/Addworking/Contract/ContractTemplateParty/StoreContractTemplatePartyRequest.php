<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateParty;

use App\Models\Addworking\Contract\ContractTemplateParty;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplatePartyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractTemplateParty::class, $this->route('contract_template')]);
    }

    public function rules()
    {
        return [
            'contract_template_party.denomination' => "required|string|max:255",
            'contract_template_party.order'        => "required|integer|min:1",
        ];
    }
}
