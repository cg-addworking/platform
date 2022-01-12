<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractTemplateAnnex\StoreContractTemplateAnnexRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateAnnex\UpdateContractTemplateAnnexRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateAnnex;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractTemplateAnnexRepository;
use Illuminate\Http\Request;

class ContractTemplateAnnexController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractTemplateAnnexRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('viewAny', [ContractTemplateAnnex::class, $contract_template]);

        $items = $this->getPaginatorFromRequest($request);
        $contract_template_annex = $this->repository->make();
        $contract_template_annex->contractTemplate()->associate($contract_template);

        return view('addworking.contract.contract_template_annex.index', compact('items', 'contract_template_annex'));
    }

    public function create(Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('create', [ContractTemplateAnnex::class, $contract_template]);

        $contract_template_annex = $this->repository->make();
        $contract_template_annex->contractTemplate()->associate($contract_template);

        return view('addworking.contract.contract_template_annex.create', compact('contract_template_annex'));
    }

    public function store(
        StoreContractTemplateAnnexRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('create', [ContractTemplateAnnex::class, $contract_template]);

        $contract_template_annex = $this->repository->createFromRequest($request, $contract_template);

        return $this->redirectWhen($contract_template_annex->exists, $contract_template_annex->routes->show);
    }

    public function show(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateAnnex $contract_template_annex
    ) {
        $this->authorize('view', $contract_template_annex);

        return view('addworking.contract.contract_template_annex.show', compact('contract_template_annex'));
    }

    public function edit(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateAnnex $contract_template_annex
    ) {
        $this->authorize('update', $contract_template_annex);

        return view('addworking.contract.contract_template_annex.edit', compact('contract_template_annex'));
    }

    public function update(
        UpdateContractTemplateAnnexRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateAnnex $contract_template_annex
    ) {
        $this->authorize('update', $contract_template_annex);

        $contract_template_annex = $this->repository->updateFromRequest($request, $contract_template_annex);

        return $this->redirectWhen($contract_template_annex->exists, $contract_template_annex->routes->show);
    }

    public function destroy(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateAnnex $contract_template_annex
    ) {
        $this->authorize('delete', $contract_template_annex);

        $deleted = $this->repository->delete($contract_template_annex);

        return $this->redirectWhen($deleted, $contract_template_annex->routes->index);
    }
}
