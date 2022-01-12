<?php

namespace App\Repositories\Addworking\Contract;

use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\StoreContractPartyDocumentTypeRequest;
use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\UpdateContractPartyDocumentTypeRequest;
use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\BaseRepository;
use App\Support\Facades\Repository;
use Illuminate\Support\Collection;

class ContractPartyDocumentTypeRepository extends BaseRepository
{
    protected $model = ContractPartyDocumentType::class;

    public function getAvailableDocumentTypes(ContractPartyDocumentType $type): Collection
    {
        $addworking = Repository::addworkingEnterprise()->getAddworkingEnterprise();
        $enterprise = $type->contractParty->contract->enterprise;
        $existing   = $type->contractParty->contractPartyDocumentTypes
            ->map(function ($contract_party_document_type) {
                return $contract_party_document_type->documentType;
            });

        return Repository::enterpriseFamily()
            ->getAncestors($enterprise, true)
            ->push($addworking)
            ->documentTypes()
            ->get()
            ->reject(fn($type) => $existing->contains($type));
    }

    public function getAvailableDocuments(ContractPartyDocumentType $type): Collection
    {
        return $type->contractParty->enterprise
            ->documents()
            ->ofDocumentType($type->documentType)
            ->latest()
            ->get();
    }

    public function getContractDocument(ContractPartyDocumentType $type): ContractDocument
    {
        return $type->contractParty->contract
            ->contractDocuments()
            ->whereContractParty($type->contractParty)
            ->whereHas('document', fn($q) => $q->ofDocumentType($type->documentType))
            ->firstOrNew([]);
    }

    public function getDocument(ContractPartyDocumentType $type): Document
    {
        return $this->getContractDocument($type)->document;
    }
}
