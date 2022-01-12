<?php

namespace App\Http\Controllers\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Contract\Contract\CreateBlankContractRequest;
use App\Http\Requests\Addworking\Contract\Contract\CreateContractFromExistingFilePostRequest;
use App\Http\Requests\Addworking\Contract\Contract\StoreContractAddendumRequest;
use App\Http\Requests\Addworking\Contract\Contract\StoreContractRequest;
use App\Http\Requests\Addworking\Contract\Contract\UpdateContractRequest;
use App\Jobs\Addworking\Contract\Contract\CreateBlankContractJob;
use App\Jobs\Addworking\Contract\Contract\CreateContractAddendumJob;
use App\Jobs\Addworking\Contract\Contract\CreateContractFromExistingFileJob;
use App\Jobs\Addworking\Contract\Contract\UpdateContractJob;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Contract\ContractRepository;
use App\Repositories\Addworking\Contract\ContractTemplateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ContractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function dispatcher(Request $request)
    {
        return redirect()->route('addworking.contract.contract.index', $request->user()->enterprise);
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $this->authorize('viewAny', [Contract::class, $enterprise]);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->ofEnterprise($enterprise)
            ->exceptAddendums()
            ->with(['enterprise', 'contractParties.enterprise', 'file', 'contractTemplate'])
            ->latest()
            ->paginate($request->input('per-page') ?: 25);

        $contract = $enterprise->contracts()->make();

        return view('addworking.contract.contract.index', compact('items', 'contract', 'enterprise'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [Contract::class, $enterprise]);

        $contract = $enterprise->contracts()->make();

        return view('addworking.contract.contract.create', compact('contract'));
    }

    public function createBlank(Enterprise $enterprise)
    {
        $this->authorize('createBlank', [Contract::class, $enterprise]);

        $contract = $enterprise->contracts()->make();

        return view('addworking.contract.contract.create_blank', compact('contract'));
    }

    public function createBlankPost(
        CreateBlankContractRequest $request,
        Enterprise $enterprise
    ) {
        $this->authorize('createBlank', [Contract::class, $enterprise]);

        ($job = new CreateBlankContractJob(
            $enterprise,
            $request->input('contract'),
        ))->handle();

        return $this->redirectWhen($job->contract->exists, $job->contract->routes->show);
    }

    public function createFromExistingFile(Enterprise $enterprise)
    {
        $this->authorize('createFromExistingFile', [Contract::class, $enterprise]);

        $contract = $enterprise->contracts()->make();

        return view('addworking.contract.contract.create_from_file', compact('contract'));
    }

    public function createFromExistingFilePost(
        CreateContractFromExistingFilePostRequest $request,
        Enterprise $enterprise
    ) {
        $this->authorize('createFromExistingFile', [Contract::class, $enterprise]);

        ($job = new CreateContractFromExistingFileJob(
            $enterprise,
            $request->input('contract'),
            $request->file('contract.file'),
        ))->handle();

        return $this->redirectWhen($job->contract->exists, $job->contract->routes->show);
    }

    public function createFromTemplate(Enterprise $enterprise)
    {
        $this->authorize('createFromTemplate', [Contract::class, $enterprise]);

        $contract  = $enterprise->contracts()->make();
        $templates = $enterprise->contractTemplates();

        return view('addworking.contract.contract.create_from_template', compact('contract', 'templates'));
    }

    public function store(StoreContractRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [Contract::class, $enterprise]);

        $contract = $this->repository->createFromRequest($request, $enterprise);

        return $this->redirectWhen($contract->exists, $contract->routes->show);
    }

    public function show(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('view', $contract);

        return view('addworking.contract.contract.show', compact('contract'));
    }

    public function edit(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('update', $contract);

        return view('addworking.contract.contract.edit', compact('contract'));
    }

    public function update(UpdateContractRequest $request, Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('update', $contract);

        $updated = ($job = new UpdateContractJob(
            $contract,
            $request->input('contract'),
            $request->file('contract.file')
        ))->handle();

        return $this->redirectWhen($updated, $contract->routes->show);
    }

    public function destroy(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('destroy', $contract);

        $deleted = $this->repository->delete($contract);

        return $this->redirectWhen($deleted, $contract->routes->index);
    }

    public function download(Enterprise $enterprise, Contract $contract)
    {
        $this->authorize('download', $contract);

        return $contract->file->download();
    }

    public function createAddendum(
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('createAddendum', $contract);

        $contract_addendum = $contract
            ->children()->make()
            ->enterprise()->associate($enterprise)
            ->parent()->associate($contract);

        return view(
            'addworking.contract.contract.create_addendum',
            compact('contract', 'contract_addendum')
        );
    }

    public function storeAddendum(
        StoreContractAddendumRequest $request,
        Enterprise $enterprise,
        Contract $contract
    ) {
        $this->authorize('createAddendum', $contract);

        $job = new CreateContractAddendumJob(
            $enterprise,
            $contract,
            $request->input('contract'),
            $request->file('contract.file')
        );

        $job->handle();

        return $this->redirectWhen(
            $job->contract->exists,
            $job->contract->parent->routes->show
        );
    }
}
