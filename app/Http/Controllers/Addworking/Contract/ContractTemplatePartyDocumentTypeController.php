<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractTemplatePartyDocumentType as FormRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractTemplatePartyDocumentTypeRepository;
use Illuminate\Http\Request;

class ContractTemplatePartyDocumentTypeController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractTemplatePartyDocumentTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Request $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('viewAny', [ContractTemplatePartyDocumentType::class, $contract_template_party]);

        $items = $this->getPaginatorFromRequest($request);
        $contract_template_party_document_type = $this->repository->make();
        $contract_template_party_document_type->contractTemplateParty()->associate($contract_template_party);

        return view(
            'addworking.contract.contract_template_party_document_type.index',
            compact('items', 'contract_template_party_document_type')
        );
    }

    public function create(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('create', [ContractTemplatePartyDocumentType::class, $contract_template_party]);

        $contract_template_party_document_type = $this->repository->make();
        $contract_template_party_document_type->contractTemplateParty()->associate($contract_template_party);

        return view(
            'addworking.contract.contract_template_party_document_type.create',
            compact('contract_template_party_document_type')
        );
    }

    public function store(
        FormRequest\StoreContractTemplatePartyDocumentTypeRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('create', [ContractTemplatePartyDocumentType::class, $contract_template_party]);

        $contract_template_party_document_type = $this->repository->createFromRequest(
            $request,
            $contract_template_party
        );

        return $this->redirectWhen(
            $contract_template_party_document_type->exists,
            $contract_template_party_document_type->routes->show
        );
    }

    public function show(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party,
        ContractTemplatePartyDocumentType $document_type
    ) {
        $this->authorize('view', $contract_template_party_document_type = $document_type);

        return view(
            'addworking.contract.contract_template_party_document_type.show',
            compact('contract_template_party_document_type')
        );
    }

    public function edit(ContractTemplatePartyDocumentType $document_type)
    {
        $this->authorize('update', $contract_template_party_document_type = $document_type);

        return view(
            'addworking.contract.contract_template_party_document_type.edit',
            compact('contract_template_party_document_type')
        );
    }

    public function update(
        FormRequest\UpdateContractTemplatePartyDocumentTypeRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party,
        ContractTemplatePartyDocumentType $document_type
    ) {
        $this->authorize('update', $contract_template_party_document_type = $document_type);

        $contract_template_party_document_type = $this->repository->updateFromRequest(
            $request,
            $contract_template_party_document_type
        );

        return $this->redirectWhen(
            $contract_template_party_document_type->exists,
            $contract_template_party_document_type->routes->show
        );
    }

    public function destroy(ContractTemplatePartyDocumentType $document_type)
    {
        $this->authorize('delete', $contract_template_party_document_type = $document_type);

        $deleted = $this->repository->delete($contract_template_party_document_type);

        return $this->redirectWhen($deleted, $contract_template_party_document_type->routes->index);
    }
}
