<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\AttachExistingDocumentPostRequest;
use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\AttachNewDocumentPostRequest;
use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\StoreContractPartyDocumentTypeRequest;
use App\Http\Requests\Addworking\Contract\ContractPartyDocumentType\UpdateContractPartyDocumentTypeRequest;
use App\Jobs\Addworking\Contract\ContractPartyDocumentType\AttachExistingDocumentJob;
use App\Jobs\Addworking\Contract\ContractPartyDocumentType\AttachNewDocumentJob;
use App\Jobs\Addworking\Contract\ContractPartyDocumentType\CreateContractPartyDocumentTypeJob;
use App\Jobs\Addworking\Contract\ContractPartyDocumentType\DetachDocumentJob;
use App\Jobs\Addworking\Contract\ContractPartyDocumentType\UpdateContractPartyDocumentTypeJob;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractPartyDocumentTypeRepository;
use App\Support\Facades\Repository;
use Illuminate\Http\Request;

class ContractPartyDocumentTypeController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractPartyDocumentTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Request $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('viewAny', [ContractPartyDocumentType::class, $contract_party]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($contract_party) {
            $query->whereContractParty($contract_party);
        });
        $contract_party_document_type = $contract_party->contractPartyDocumentTypes()->make();

        return view(
            'addworking.contract.contract_party_document_type.index',
            compact('items', 'contract_party_document_type')
        );
    }

    public function create(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('create', [ContractPartyDocumentType::class, $contract_party]);

        $contract_party_document_type = $contract_party->contractPartyDocumentTypes()->make();

        return view(
            'addworking.contract.contract_party_document_type.create',
            compact('contract_party_document_type')
        );
    }

    public function store(
        StoreContractPartyDocumentTypeRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('create', [ContractPartyDocumentType::class, $contract_party]);

        ($job = new CreateContractPartyDocumentTypeJob(
            $contract_party,
            $request->input('contract_party_document_type')
        ))->handle();

        return $this->redirectWhen(
            $job->contractPartyDocumentType->exists,
            $job->contractPartyDocumentType->routes->index
        );
    }

    public function show(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('view', $contract_party_document_type);

        return view(
            'addworking.contract.contract_party_document_type.show',
            compact('contract_party_document_type')
        );
    }

    public function edit(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('update', $contract_party_document_type);

        return view(
            'addworking.contract.contract_party_document_type.edit',
            compact('contract_party_document_type')
        );
    }

    public function update(
        UpdateContractPartyDocumentTypeRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('update', $contract_party_document_type);

        ($job = new UpdateContractPartyDocumentTypeJob(
            $contract_party_document_type,
            $request->input('contract_party_document_type')
        ))->handle();

        return $this->redirectWhen(
            $contract_party_document_type->exists,
            $contract_party_document_type->routes->index
        );
    }

    public function destroy(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('delete', $contract_party_document_type);

        $deleted = $this->repository->delete($contract_party_document_type);

        return $this->redirectWhen(
            $deleted,
            $contract_party_document_type->routes->index
        );
    }

    public function attachExistingDocument(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('attachExistingDocument', $contract_party_document_type);

        return view(
            'addworking.contract.contract_party_document_type.attach_existing_document',
            compact('contract_party_document_type')
        );
    }

    public function attachExistingDocumentPost(
        AttachExistingDocumentPostRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('attachExistingDocument', $contract_party_document_type);

        $created = (new AttachExistingDocumentJob(
            $contract_party_document_type,
            Repository::enterpriseDocument()->find(
                $request->input('contract_party_document_type.document')
            )
        ))->handle();

        return $this->redirectWhen(
            $created,
            $contract_party_document_type->routes->index
        );
    }

    public function attachNewDocument(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('attachNewDocument', $contract_party_document_type);

        return view(
            'addworking.contract.contract_party_document_type.attach_new_document',
            compact('contract_party_document_type')
        );
    }

    public function attachNewDocumentPost(
        AttachNewDocumentPostRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('attachNewDocument', $contract_party_document_type);

        $created = (new AttachNewDocumentJob(
            $contract_party_document_type,
            $request->file('contract_party_document_type.document')
        ))->handle();

        return $this->redirectWhen(
            $created,
            $contract_party_document_type->routes->index
        );
    }

    public function detachDocument(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party,
        ContractPartyDocumentType $contract_party_document_type
    ) {
        $this->authorize('detachDocument', $contract_party_document_type);

        $deleted = (new DetachDocumentJob(
            $contract_party_document_type
        ))->handle();

        return $this->redirectWhen(
            $deleted,
            $contract_party_document_type->routes->index
        );
    }
}
