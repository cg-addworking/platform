<?php

namespace Components\Contract\Model\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Requests\StoreContractModelPartyDocumentTypeRequest;
use Components\Contract\Model\Application\Requests\StoreContractModelPartyDocumentTypeSpecificDocumentRequest;
use Components\Contract\Model\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\UseCases\CreateSpecificDocumentForContractModel;
use Components\Contract\Model\Domain\UseCases\DefineDocumentTypeForContractModel;
use Components\Contract\Model\Domain\UseCases\DeleteDocumentTypeForContractModel;
use Components\Contract\Model\Domain\UseCases\ListDocumentTypeOfContractModelParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ContractModelPartyDocumentTypeController extends Controller
{
    public function index(ContractModel $contract_model, ContractModelParty $contract_model_party)
    {
        $this->authorize('index', ContractModelDocumentType::class);

        $items = App::make(ListDocumentTypeOfContractModelParty::class)
            ->handle(Auth::User(), $contract_model_party);

        return view(
            'contract_model::contract_model_document_type.index',
            compact('items', 'contract_model_party', 'contract_model')
        );
    }

    public function create(ContractModel $contract_model, ContractModelParty $contract_model_party)
    {
        $this->authorize('create', [ContractModelDocumentType::class, $contract_model_party]);

        $enterprise = $contract_model->getEnterprise();
        $document_types = App::make(DocumentTypeRepositoryInterface::class)
            ->getFromEnterpriseExcludeThoseInContractModelParty($enterprise, $contract_model_party);

        return view(
            'contract_model::contract_model_document_type.create',
            compact('contract_model', 'contract_model_party', 'document_types')
        );
    }

    public function store(
        StoreContractModelPartyDocumentTypeRequest $request,
        ContractModel $contract_model,
        ContractModelParty $contract_model_party
    ) {
        $this->authorize('create', [ContractModelDocumentType::class, $contract_model_party]);

        $saved = [];
        if ($request->has('contract_model_document_type')) {
            $saved = $this->handleRequest($request, $contract_model_party);
        }

        return $this->redirectWhen(
            count($saved),
            route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party])
        );
    }

    private function handleRequest(Request $request, ContractModelParty $contract_model_party): array
    {
        $saved = [];
        foreach ($request->input('contract_model_document_type') as $input) {
            if (array_key_exists('document_type_id', $input)) {
                $saved[] = App::make(DefineDocumentTypeForContractModel::class)
                    ->handle(Auth::User(), $contract_model_party, $input);
            }
        }
        return $saved;
    }

    public function createSpecificDocument(ContractModel $contract_model, ContractModelParty $contract_model_party)
    {
        $this->authorize('create', [ContractModelDocumentType::class, $contract_model_party]);

        return view(
            'contract_model::contract_model_document_type.create_specific_document',
            compact('contract_model', 'contract_model_party')
        );
    }

    public function storeSpecificDocument(
        StoreContractModelPartyDocumentTypeSpecificDocumentRequest $request,
        ContractModel $contract_model,
        ContractModelParty $contract_model_party
    ) {
        $saved = App::make(CreateSpecificDocumentForContractModel::class)
            ->handle(
                Auth::user(),
                $contract_model_party,
                $request->input('contract_model_document_type'),
                $request->file('contract_model_document_type.document_model')
            );

        return $this->redirectWhen(
            $saved,
            route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party])
        );
    }

    public function delete(
        ContractModel $contract_model,
        ContractModelParty $contract_model_party,
        ContractModelDocumentType $contract_model_document_type
    ) {
        $this->authorize('delete', $contract_model_document_type);

        $deleted = App::make(DeleteDocumentTypeForContractModel::class)
            ->handle(Auth::User(), $contract_model_document_type, $contract_model_party);

        return $this->redirectWhen(
            $deleted,
            route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party])
        );
    }
}
