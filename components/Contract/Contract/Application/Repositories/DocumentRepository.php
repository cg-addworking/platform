<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\DocumentRepository as AppDocumentRepository;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Interfaces\Repositories\DocumentRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function make(): Document
    {
        return new Document;
    }

    public function create(
        Contract $contract,
        Enterprise $enterprise,
        Request $request
    ): Document {
        $document_type = ContractModelDocumentType::find($request->contract_model_document_type);
        $files = $request->hasFile('document_files')
            ? App::make(AppDocumentRepository::class)->generateFilesFromInputs(
                $request->file('document_files'),
                $enterprise,
                $document_type
            )
            : App::make(AppDocumentRepository::class)->generateFilesFromJson(
                $request->get('document_files'),
                $enterprise,
                $document_type
            );

        $document = tap(new Document, function (Document $doc) use ($request, $enterprise, $files, $contract) {
            $doc->fill($request->input('document'))
                ->enterprise()->associate($enterprise)
                ->contract()->associate($contract)
                ->contractModelPartyDocumentType()->associate($request->contract_model_document_type)
                ->save();

            $doc->files()->saveMany($files);
            $doc->save();
        });

        return $document;
    }
}
