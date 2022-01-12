<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Events\Addworking\Enterprise\Document\DocumentCreated;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractModelDocumentTypeRepository implements ContractModelDocumentTypeRepositoryInterface
{
    public function make(array $data = []): ContractModelDocumentType
    {
        return new ContractModelDocumentType($data);
    }

    public function list(ContractPartyEntityInterface $contract_party, ?array $filter = null, ?string $search = null)
    {
        $contract_model_party = $contract_party->getContractModelParty();

        return ContractModelDocumentType::whereHas('contractModelParty', function ($query) use ($contract_model_party) {
            return $query->where('id', $contract_model_party->getId());
        })->latest()->paginate(25);
    }

    public function getDocumentsOfParty(ContractPartyEntityInterface $contract_party)
    {
        $contract_model_party = $contract_party->getContractModelParty();

        return DocumentType::whereHas('contractModelPartyDocumentTypes', function ($query) use ($contract_model_party) {
            return $query->where('contract_model_party_id', $contract_model_party->getId());
        })->latest()->get();
    }

    public function createSpecificDocument(
        Request $request,
        Enterprise $enterprise
    ): Document {
        return DB::transaction(function () use ($request, $enterprise) {

            $file = $request->file('document_files');

            $document = tap(new Document, function (Document $doc) use ($request, $enterprise, $file) {
                $doc->fill($request->input('document'))
                    ->enterprise()->associate($enterprise)
                    ->contract()->associate($request->contract)
                    ->contractModelPartyDocumentType()->associate($request->contract_model_document_type)
                    ->save();

                $doc->files()->attach($file);
                $doc->save();
            });

            event(new DocumentCreated($document));

            return $document;
        });
    }
}
