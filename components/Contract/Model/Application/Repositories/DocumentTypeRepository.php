<?php

namespace Components\Contract\Model\Application\Repositories;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Illuminate\Support\Facades\App;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function find(string $id): ?DocumentType
    {
        return DocumentType::find($id);
    }

    public function getFromEnterpriseExcludeThoseInContractModelParty(
        Enterprise $enterprise,
        ContractModelPartyEntityInterface $contract_model_party
    ) {
        $party_document_types = App::make(ContractModelDocumentTypeRepository::class)
            ->getFromContractModelParty($contract_model_party);

        return DocumentType::whereHas('enterprise', function ($query) use ($enterprise) {
            $ancestors = app(FamilyEnterpriseRepository::class)->getAncestors($enterprise, true);
            $addworking = Enterprise::where('name', 'ADDWORKING')->first();
            $ancestors->push($addworking);
            return $query->whereIn('id', $ancestors->pluck('id'));
        })->whereNotIn('id', $party_document_types->pluck('document_type_id'))->get();
    }

    public function findByDisplayName(string $display_name): ?DocumentType
    {
        return DocumentType::where('display_name', $display_name)->first();
    }
}
