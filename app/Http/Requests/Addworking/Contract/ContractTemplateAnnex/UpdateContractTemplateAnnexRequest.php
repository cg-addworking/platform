<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplateAnnex;

use App\Models\Addworking\Contract\ContractTemplateAnnex;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTemplateAnnexRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_template_annex'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
