<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplatePartyDocumentType;

use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractTemplatePartyDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('contract_template_party_document_type'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
