<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractModelPartyDocumentTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_model_document_type.*.document_type_id'
                => "required|uuid|exists:addworking_enterprise_document_types,id",
            'contract_model_document_type.*.validation_required' => "required|bool",
        ];
    }
}
