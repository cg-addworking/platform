<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractVariable\StoreContractVariableRequest;
use App\Http\Requests\Addworking\Contract\ContractVariable\UpdateContractVariableRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractVariable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractVariableRepository;
use Illuminate\Http\Request;

class ContractVariableController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractVariableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('viewAny', [ContractVariable::class, $contract]);

        $items = $this->getPaginatorFromRequest($request);
        $contract_variable = $this->repository->make();
        $contract_variable->contract()->associate($contract);

        return view('addworking.contract.contract_variable.index', compact('items', 'contract_variable'));
    }

    public function create(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('create', [ContractVariable::class, $contract]);

        $contract_variable = $this->repository->make();
        $contract_variable->contract()->associate($contract);

        return view('addworking.contract.contract_variable.create', compact('contract_variable'));
    }

    public function store(StoreContractVariableRequest $request, Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('create', [ContractVariable::class, $contract]);

        $contract_variable = $this->repository->createFromRequest($request, $contract);

        return $this->redirectWhen($contract_variable->exists, $contract_variable->routes->show);
    }

    public function show(Enterprise $enterprise, Contract $contract, ContractVariable $contract_variable)
    {
        $this->authorize('view', $contract_variable);

        return view('addworking.contract.contract_variable.show', compact('contract_variable'));
    }

    public function edit(Enterprise $enterprise, Contract $contract, ContractVariable $contract_variable)
    {
        $this->authorize('update', $contract_variable);

        return view('addworking.contract.contract_variable.edit', compact('contract_variable'));
    }

    public function update(
        UpdateContractVariableRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractVariable $contract_variable
    ) {
        $this->authorize('update', $contract_variable);

        $contract_variable = $this->repository->updateFromRequest($request, $contract_variable);

        return $this->redirectWhen($contract_variable->exists, $contract_variable->routes->show);
    }

    public function destroy(Enterprise $enterprise, Contract $contract, ContractVariable $contract_variable)
    {
        $this->authorize('delete', $contract_variable);

        $deleted = $this->repository->delete($contract_variable);

        return $this->redirectWhen($deleted, $contract_variable->routes->index);
    }
}
