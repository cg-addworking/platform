<?php

namespace App\Http\Requests\Addworking\Contract\ContractDocument;

use App\Models\Addworking\Contract\ContractDocument;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_document'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
