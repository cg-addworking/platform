<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractDocument\StoreContractDocumentRequest;
use App\Http\Requests\Addworking\Contract\ContractDocument\UpdateContractDocumentRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractDocumentRepository;
use Illuminate\Http\Request;

class ContractDocumentController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Request $request,
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('viewAny', [ContractDocument::class, $contract]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($contract) {
            $query->whereContract($contract);
        });
        $contract_document = $this->repository->make();
        $contract_document->contract()->associate($contract);

        return view(
            'addworking.contract.contract_document.index',
            compact('items', 'contract_document')
        );
    }

    public function create(
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('create', [ContractDocument::class, $contract]);

        $contract_document = $this->repository->make();
        $contract_document->contract()->associate($contract);

        return view(
            'addworking.contract.contract_document.create',
            compact('contract_document')
        );
    }

    public function store(
        StoreContractDocumentRequest $request,
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('create', [ContractDocument::class, $contract]);

        $contract_document = $this->repository->createFromRequest($request, $contract);

        return $this->redirectWhen(
            $contract_document->exists,
            $contract_document->routes->show
        );
    }

    public function show(
        Enterprise $enterprise,
        Contract $contract,
        ContractDocument $contract_document
    ) {
        $this->authorize('view', $contract_document);

        return view(
            'addworking.contract.contract_document.show',
            compact('contract_document')
        );
    }

    public function edit(
        Enterprise $enterprise,
        Contract $contract,
        ContractDocument $contract_document
    ) {
        $this->authorize('update', $contract_document);

        return view(
            'addworking.contract.contract_document.edit',
            compact('contract_document')
        );
    }

    public function update(
        UpdateContractDocumentRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractDocument $contract_document
    ) {
        $this->authorize('update', $contract_document);

        $contract_document = $this->repository->updateFromRequest($request, $contract_document);

        return $this->redirectWhen(
            $contract_document->exists,
            $contract_document->routes->show
        );
    }

    public function destroy(
        Enterprise $enterprise,
        Contract $contract,
        ContractDocument $contract_document
    ) {
        $this->authorize('delete', $contract_document);

        $deleted = $this->repository->delete($contract_document);

        return $this->redirectWhen(
            $deleted,
            $contract_document->routes->index
        );
    }
}
