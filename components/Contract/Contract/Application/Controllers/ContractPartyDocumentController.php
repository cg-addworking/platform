<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Jobs\UpdateContractStateByDocumentValidationJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\DocumentRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\UseCases\ListContractPartyDocument;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractPartyDocumentController extends Controller
{
    private $userRepository;
    private $documentRepository;

    public function __construct(
        UserRepository $userRepository,
        DocumentRepository $documentRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentRepository = $documentRepository;
    }

    public function index(Contract $contract, ContractParty $contract_party)
    {
        $this->authorize('indexDocument', $contract_party);

        $items = App::make(ListContractPartyDocument::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_party
        );

        return view('contract::contract_party_document.index', compact('items', 'contract_party', 'contract'));
    }

    public function createSpecificDocument(Contract $contract, Enterprise $enterprise, Request $request)
    {
        $document_type = ContractModelDocumentType::find($request->contract_model_document_type);

        $document = $this->documentRepository->make()
        ->enterprise()->associate($enterprise)
        ->contract()->associate($contract)
        ->contractModelPartyDocumentType()->associate($document_type);

        return view('contract::contract_party_document.create_specific_document', compact(
            'document',
            'enterprise',
            'document_type',
            'contract',
        ));
    }

    public function storeSpecificDocument(Contract $contract, Enterprise $enterprise, Request $request)
    {
        $saved = $this->documentRepository->create($contract, $enterprise, $request);
       
        UpdateContractStateByDocumentValidationJob::dispatchSync($saved);

        return $this->redirectWhen($saved->exists, route('contract.show', $contract));
    }
}
