<?php

namespace App\Http\Requests\Addworking\Contract\ContractAnnex;

use App\Models\Addworking\Contract\ContractAnnex;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractAnnexRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractAnnex::class, $this->route('contract')]);
    }

    public function rules()
    {
        return [
            'contract_annex.file' => 'required|file|min:1|max:4000|mimes:pdf',
        ];
    }
}
