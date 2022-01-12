<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractTemplatePartyDocumentType as Request;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use App\Repositories\BaseRepository;

class ContractTemplatePartyDocumentTypeRepository extends BaseRepository
{
    protected $model = ContractTemplatePartyDocumentType::class;

    public function createFromRequest(
        Request\StoreContractTemplatePartyDocumentTypeRequest $request,
        ContractTemplateParty $party
    ): ContractTemplatePartyDocumentType {
        return tap($this->make([
                'validation_required' => $request->has('contract_template_party_document_type.validation_required'),
            ]), function ($type) use ($request, $party) {
                $type
                    ->contractTemplateParty()->associate($party)
                    ->documentType()->associate($request->input('document_type.id'))
                    ->save();
            });
    }

    public function updateFromRequest(
        Request\UpdateContractTemplatePartyDocumentTypeRequest $request,
        ContractTemplatePartyDocumentType $type
    ): ContractTemplatePartyDocumentType {
        return $this->update($type, $request->input('contract_template_party_document_type', []));
    }
}
