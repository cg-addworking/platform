<?php

namespace App\Http\Requests\Addworking\Contract\ContractParty;

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractPartyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractParty::class, $this->route('contract')]);
    }

    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();

        return [
            'contract_party.enterprise'   => "required|uuid|exists:{$enterprise},id",
            'contract_party.denomination' => "required|string|max:255"
        ];
    }
}
