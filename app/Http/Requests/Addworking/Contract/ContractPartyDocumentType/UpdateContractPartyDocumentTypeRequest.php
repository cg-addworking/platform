<?php

namespace App\Http\Requests\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractPartyDocumentType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractPartyDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_party_document_type'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
