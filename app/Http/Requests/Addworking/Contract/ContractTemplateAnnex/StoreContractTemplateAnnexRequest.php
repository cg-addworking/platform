<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateAnnex;

use App\Models\Addworking\Contract\ContractTemplateAnnex;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplateAnnexRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractTemplateAnnex::class, $this->route('contract_template')]);
    }

    public function rules()
    {
        return [
            'contract_template_annex.file' => 'required|file|min:1|mimes:pdf|max:4000',
        ];
    }
}
