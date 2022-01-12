<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractAnnex\StoreContractAnnexRequest;
use App\Http\Requests\Addworking\Contract\ContractAnnex\UpdateContractAnnexRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractAnnex;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractAnnexRepository;
use Illuminate\Http\Request;

class ContractAnnexController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractAnnexRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('viewAny', [ContractAnnex::class, $contract]);

        $items = $this->getPaginatorFromRequest($request);
        $contract_annex = $this->repository->make();
        $contract_annex->contract()->associate($contract);

        return view('addworking.contract.contract_annex.index', compact('items', 'contract_annex'));
    }

    public function create(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('create', [ContractAnnex::class, $contract]);

        $contract_annex = $this->repository->make();
        $contract_annex->contract()->associate($contract);

        return view('addworking.contract.contract_annex.create', compact('contract_annex'));
    }

    public function store(StoreContractAnnexRequest $request, Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('create', [ContractAnnex::class, $contract]);

        $contract_annex = $this->repository->createFromRequest($request, $contract);

        return $this->redirectWhen($contract_annex->exists, $contract_annex->routes->show);
    }

    public function show(Enterprise $enterprise, Contract $contract, ContractAnnex $contract_annex)
    {
        $this->authorize('view', $contract_annex);

        return view('addworking.contract.contract_annex.show', compact('contract_annex'));
    }

    public function edit(Enterprise $enterprise, Contract $contract, ContractAnnex $contract_annex)
    {
        $this->authorize('update', $contract_annex);

        return view('addworking.contract.contract_annex.edit', compact('contract_annex'));
    }

    public function update(
        UpdateContractAnnexRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractAnnex $contract_annex
    ) {
        $this->authorize('update', $contract_annex);

        $contract_annex = $this->repository->updateFromRequest($request, $contract_annex);

        return $this->redirectWhen($contract_annex->exists, $contract_annex->routes->show);
    }

    public function destroy(Enterprise $enterprise, Contract $contract, ContractAnnex $contract_annex)
    {
        $this->authorize('delete', $contract_annex);

        $deleted = $this->repository->delete($contract_annex);

        return $this->redirectWhen($deleted, $contract_annex->routes->index);
    }
}
