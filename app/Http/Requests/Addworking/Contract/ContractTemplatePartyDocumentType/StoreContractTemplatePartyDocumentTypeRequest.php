<?php

namespace App\Http\Requests\Addworking\Contract\ContractTemplatePartyDocumentType;

use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplatePartyDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [
            ContractTemplatePartyDocumentType::class, $this->route('contract_template_party')
        ]);
    }

    public function rules()
    {
        return [
            'document_type.id' => "required|uuid|exists:addworking_enterprise_document_types,id",
            'contract_template_party_document_type.mandatory' => "sometimes",
            'contract_template_party_document_type.validation_required' => "sometimes",
        ];
    }
}
