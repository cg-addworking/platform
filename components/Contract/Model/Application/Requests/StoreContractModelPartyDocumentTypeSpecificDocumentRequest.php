<?php

namespace Components\Contract\Model\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractModelPartyDocumentTypeSpecificDocumentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_model_document_type.display_name' => "required|string",
            'contract_model_document_type.description' => "nullable|string",
            'contract_model_document_type.validation_required' => "required|bool",
            'contract_model_document_type.document_model' => "nullable|file|max:4000",
        ];
    }
}
