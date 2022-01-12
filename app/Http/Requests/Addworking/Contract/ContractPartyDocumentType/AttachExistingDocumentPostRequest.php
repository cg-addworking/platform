<?php

namespace App\Http\Requests\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Enterprise\Document;
use App\Support\Facades\Repository;
use Illuminate\Foundation\Http\FormRequest;

class AttachExistingDocumentPostRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('attachExistingDocument', $this->route('contract_party_document_type'));
    }

    public function rules()
    {
        $ids = Repository::contractPartyDocumentType()
            ->getAvailableDocuments($this->route('contract_party_document_type'))
            ->pluck('id')
            ->join(',');

        return [
            'contract_party_document_type.document' => "required|uuid|in:{$ids}",
        ];
    }
}
