<?php

namespace App\Http\Requests\Addworking\Contract\ContractAnnex;

use App\Models\Addworking\Contract\ContractAnnex;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractAnnexRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_annex'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
