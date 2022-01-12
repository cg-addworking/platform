<?php

namespace App\Http\Requests\Addworking\Contract\ContractDocument;

use App\Models\Addworking\Contract\ContractDocument;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [ContractDocument::class, $this->route('contract')]);
    }

    public function rules()
    {
        $contract_party_table = (new ContractDocument)->contractParty->getTable();
        $document_table       = (new ContractDocument)->document->getTable();

        return [
            "contract_party.id" => "required|uuid|exists:{$contract_party_table},id",
            "document.id"       => "required|uuid|exists:{$document_table},id",
        ];
    }
}
