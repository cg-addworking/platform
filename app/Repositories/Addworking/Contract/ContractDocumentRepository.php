<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractDocument\StoreContractDocumentRequest;
use App\Http\Requests\Addworking\Contract\ContractDocument\UpdateContractDocumentRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Repositories\BaseRepository;

class ContractDocumentRepository extends BaseRepository
{
    protected $model = ContractDocument::class;

    public function createFromRequest(StoreContractDocumentRequest $request, Contract $contract): ContractDocument
    {
        return tap($this->make(), function ($doc) use ($request, $contract) {
            $doc
                ->contract()->associate($contract)
                ->contractParty()->associate($request->input('contract_party.id'))
                ->document()->associate($request->input('document.id'))
                ->save();
        });
    }

    public function updateFromRequest(
        UpdateContractDocumentRequest $request,
        ContractDocument $contract_document
    ): ContractDocument {
        return $this->update($contract_document, $request->input('contract_document', []));
    }

    public function getContractPartyDocumentType(ContractDocument $document): ContractPartyDocumentType
    {
        return ContractPartyDocumentType::query()
            ->whereHas('contractParty', fn($q) => $q->whereId($document->contractParty->id))
            ->whereHas('documentType', fn($q) => $q->whereId($document->document->documentType->id))
            ->firstOrNew([]);
    }
}
