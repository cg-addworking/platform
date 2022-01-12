<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractTemplateVariable\StoreContractTemplateVariableRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateVariable\UpdateContractTemplateVariableRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractTemplateVariableRepository;
use Illuminate\Http\Request;

class ContractTemplateVariableController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractTemplateVariableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('viewAny', [ContractTemplateVariable::class, $contract_template]);

        $items = $this->getPaginatorFromRequest($request);
        $contract_template_variable = $this->repository->make();
        $contract_template_variable->contractTemplate()->associate($contract_template);

        return view(
            'addworking.contract.contract_template_variable.index',
            compact('items', 'contract_template_variable')
        );
    }

    public function create(Enterprise $enterprise, ContractTemplate $contract_template)
    {
        $this->authorize('create', [ContractTemplateVariable::class, $contract_template]);

        $contract_template_variable = $this->repository->make();
        $contract_template_variable->contractTemplate()->associate($contract_template);

        return view('addworking.contract.contract_template_variable.create', compact('contract_template_variable'));
    }

    public function store(
        StoreContractTemplateVariableRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template
    ) {
        $this->authorize('create', [ContractTemplateVariable::class, $contract_template]);

        $contract_template_variable = $this->repository->createFromRequest($request, $contract_template);

        return $this->redirectWhen($contract_template_variable->exists, $contract_template_variable->routes->show);
    }

    public function show(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateVariable $contract_template_variable
    ) {
        $this->authorize('view', $contract_template_variable);

        return view('addworking.contract.contract_template_variable.show', compact('contract_template_variable'));
    }

    public function edit(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateVariable $contract_template_variable
    ) {
        $this->authorize('update', $contract_template_variable);

        return view('addworking.contract.contract_template_variable.edit', compact('contract_template_variable'));
    }

    public function update(
        UpdateContractTemplateVariableRequest $request,
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateVariable $contract_template_variable
    ) {
        $this->authorize('update', $contract_template_variable);

        $contract_template_variable = $this->repository->updateFromRequest($request, $contract_template_variable);

        return $this->redirectWhen($contract_template_variable->exists, $contract_template_variable->routes->show);
    }

    public function destroy(
        Enterprise $enterprise,
        ContractTemplate $contract_template,
        ContractTemplateVariable $contract_template_variable
    ) {
        $this->authorize('delete', $contract_template_variable);

        $deleted = $this->repository->delete($contract_template_variable);

        return $this->redirectWhen($deleted, $contract_template_variable->routes->index);
    }
}
