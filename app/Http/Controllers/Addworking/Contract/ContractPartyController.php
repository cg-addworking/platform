<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\ContractParty\AssignSignatoryPutRequest;
use App\Http\Requests\Addworking\Contract\ContractParty\StoreContractPartyRequest;
use App\Http\Requests\Addworking\Contract\ContractParty\UpdateContractPartyRequest;
use App\Jobs\Addworking\Contract\ContractParty\CreateContractPartyJob;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractPartyRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Support\Facades\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractPartyController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractPartyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Request $request,
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('viewAny', [ContractParty::class, $contract]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($contract) {
            return $query->ofContract($contract)->orderBy('order');
        });

        $contract_party = $contract->contractParties()->make();

        return view(
            'addworking.contract.contract_party.index',
            compact('items', 'contract_party')
        );
    }

    public function create(
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('create', [ContractParty::class, $contract]);

        $contract_party = $contract->contractParties()->make();

        return view(
            'addworking.contract.contract_party.create',
            compact('contract_party')
        );
    }

    public function store(
        StoreContractPartyRequest $request,
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('create', [ContractParty::class, $contract]);

        $party_enterprise = Repository::enterprise()
            ->find($request->input('contract_party.enterprise'));

        $created = ($job = new CreateContractPartyJob(
            $contract,
            $party_enterprise,
            $request->input('contract_party')
        ))->handle();

        return $this->redirectWhen(
            $created,
            $job->contractParty->routes->index
        );
    }

    public function show(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('view', $contract_party);

        return view(
            'addworking.contract.contract_party.show',
            compact('contract_party')
        );
    }

    public function edit(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('update', $contract_party);

        return view(
            'addworking.contract.contract_party.edit',
            compact('contract_party')
        );
    }

    public function update(
        UpdateContractPartyRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('update', $contract_party);

        $updated = $this->repository->update(
            $contract_party,
            $request->input('contract_party')
        );

        return $this->redirectWhen(
            $updated,
            $contract_party->routes->index
        );
    }

    public function destroy(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('delete', $contract_party);

        $deleted = $this->repository->delete(
            $contract_party
        );

        return $this->redirectWhen(
            $deleted,
            $contract_party->routes->index
        );
    }

    public function assignSignatory(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('assignSignatory', $contract_party);

        return view(
            'addworking.contract.contract_party.assign_signatory',
            compact('contract_party')
        );
    }

    public function assignSignatoryPut(
        AssignSignatoryPutRequest $request,
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('assignSignatory', $contract_party);

        $updated = $contract_party->user()
            ->associate($request->input('contract_party.user'))
            ->save();

        return $this->redirectWhen(
            $updated,
            $contract_party->routes->index
        );
    }

    public function dissociateSignatory(
        Enterprise $enterprise,
        Contract $contract,
        ContractParty $contract_party
    ) {
        $this->authorize('dissociateSignatory', $contract_party);

        $deleted = $contract_party->user()
            ->dissociate()
            ->save();

        return $this->redirectWhen(
            $deleted,
            $contract_party->routes->index
        );
    }
}
