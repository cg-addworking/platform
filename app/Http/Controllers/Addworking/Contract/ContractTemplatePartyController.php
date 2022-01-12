<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractTemplateParty\StoreContractTemplatePartyRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateParty\UpdateContractTemplatePartyRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractTemplatePartyRepository;
use Illuminate\Http\Request;

class ContractTemplatePartyController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractTemplatePartyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Request $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('viewAny', [ContractTemplateParty::class, $contract_template]);

        $items = $this->getPaginatorFromRequest($request, function ($query) {
            return $query->orderBy('order');
        });
        $contract_template_party = $this->repository->make();
        $contract_template_party->contractTemplate()->associate($contract_template);

        return view('addworking.contract.contract_template_party.index', compact('items', 'contract_template_party'));
    }

    public function create(
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('create', [ContractTemplateParty::class, $contract_template]);

        $contract_template_party = $this->repository->make();
        $contract_template_party->contractTemplate()->associate($contract_template);

        return view('addworking.contract.contract_template_party.create', compact('contract_template_party'));
    }

    public function store(
        StoreContractTemplatePartyRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('create', [ContractTemplateParty::class, $contract_template]);

        $contract_template_party = $this->repository->createFromRequest($request, $contract_template);

        return $this->redirectWhen($contract_template_party->exists, $contract_template_party->routes->show);
    }

    public function show(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('view', $contract_template_party);

        return view('addworking.contract.contract_template_party.show', compact('contract_template_party'));
    }

    public function edit(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('update', $contract_template_party);

        return view('addworking.contract.contract_template_party.edit', compact('contract_template_party'));
    }

    public function update(
        UpdateContractTemplatePartyRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('update', $contract_template_party);

        $contract_template_party = $this->repository->updateFromRequest($request, $contract_template_party);

        return $this->redirectWhen($contract_template_party->exists, $contract_template_party->routes->show);
    }

    public function destroy(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateParty $contract_template_party
    ) {
        $this->authorize('delete', $contract_template_party);

        $deleted = $this->repository->delete($contract_template_party);

        return $this->redirectWhen($deleted, $contract_template_party->routes->index);
    }
}
