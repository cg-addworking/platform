<?php

namespace App\Http\Requests\Addworking\Contract\ContractPartyDocumentType;

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Support\Facades\Repository;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractPartyDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('create', [ContractPartyDocumentType::class, $this->route('contract_party')]);
    }

    public function rules()
    {
        $contract_party_document_type = $this->route('contract_party')
            ->contractPartyDocumentTypes()
            ->make();

        $document_type = (new DocumentType)->getTable();
        $document_type_ids = Repository::contractPartyDocumentType()
            ->getAvailableDocumentTypes($contract_party_document_type)
            ->pluck('id')
            ->join(',');

        return [
            'contract_party_document_type.document_type' => [
                "required",
                "uuid",
                "exists:{$document_type},id",
                "in:{$document_type_ids}",
            ],
            'contract_party_document_type.mandatory' => "nullable|boolean",
            'contract_party_document_type.validation_required' => "nullable|boolean",
        ];
    }
}
