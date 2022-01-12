<?php

namespace App\Http\Requests\Addworking\Contract\ContractPartyDocumentType;

use Illuminate\Foundation\Http\FormRequest;

class AttachNewDocumentPostRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('attachNewDocument', $this->route('contract_party_document_type'));
    }

    public function rules()
    {
        return [
            'contract_party_document_type.document' => "required|file|mimes:pdf|max:4000|min:1",
        ];
    }
}
