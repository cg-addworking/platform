<?php

namespace App\Http\Controllers\Addworking\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractTemplate\StoreContractTemplateRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplate\UpdateContractTemplateRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractTemplateRepository;
use Carbon\Carbon;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class ContractTemplateController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $this->authorize('viewAny', [ContractTemplate::class, $enterprise]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            $query->ofEnterprise($enterprise);
        });
        $contract_template = $this->repository->make();
        $contract_template->enterprise()->associate($enterprise);

        return view('addworking.contract.contract_template.index', compact('items', 'contract_template'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [ContractTemplate::class, $enterprise]);

        $contract_template = $this->repository->make();
        $contract_template->enterprise()->associate($enterprise);

        return view('addworking.contract.contract_template.create', compact('contract_template'));
    }

    public function store(StoreContractTemplateRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [ContractTemplate::class, $enterprise]);

        $contract_template = $this->repository->createFromRequest($request, $enterprise);

        return $this->redirectWhen($contract_template->exists, $contract_template->routes->show);
    }

    public function show(Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('view', $contract_template);

        return view('addworking.contract.contract_template.show', compact('contract_template'));
    }

    public function edit(Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('update', $contract_template);

        return view('addworking.contract.contract_template.edit', compact('contract_template'));
    }

    public function update(
        UpdateContractTemplateRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('update', $contract_template);

        $update = $this->repository->updateFromRequest($request, $enterprise, $contract_template);

        return $this->redirectWhen($update, $contract_template->routes->show);
    }

    public function destroy(Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('delete', $contract_template);

        $contract_template->update(['deleted_at' => Carbon::now()]);

        $deleted = $this->repository->delete($contract_template);

        return $this->redirectWhen($deleted, $contract_template->routes->index);
    }
}
