<?php

namespace Components\Contract\Model\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Requests\StoreContractModelRequest;
use Components\Contract\Model\Application\Requests\UpdateContractModelRequest;
use Components\Contract\Model\Domain\UseCases\ArchiveContractModel;
use Components\Contract\Model\Domain\UseCases\CreateContractModelPartPreview;
use Components\Contract\Model\Domain\UseCases\CreateEmptyContractModel;
use Components\Contract\Model\Domain\UseCases\DeleteContractModel;
use Components\Contract\Model\Domain\UseCases\DuplicateContractModel;
use Components\Contract\Model\Domain\UseCases\EditContractModel;
use Components\Contract\Model\Domain\UseCases\ListContractModelAsSupport;
use Components\Contract\Model\Domain\UseCases\PublishContractModel;
use Components\Contract\Model\Domain\UseCases\ShowContractModel;
use Components\Contract\Model\Domain\UseCases\UnpublishContractModel;
use Components\Contract\Model\Domain\UseCases\VersionateContractModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractModelController extends Controller
{
    protected $contractModelRepository;
    protected $userRepository;

    public function __construct(
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository          = $userRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', ContractModel::class);

        $user = $this->userRepository->connectedUser();

        $items = App::make(ListContractModelAsSupport::class)
            ->handle(
                $user,
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page'),
                $request->input('operator'),
                $request->input('field')
            );

        $searchable_attributes = $this->contractModelRepository->getSearchableAttributes();

        $enterprises_with_model = Enterprise::has('contractModels')->orderBy('name')->cursor()->pluck('name', 'id');

        return view(
            'contract_model::contract_model.index',
            compact(
                'items',
                'searchable_attributes',
                'enterprises_with_model'
            )
        );
    }

    public function create()
    {
        $this->authorize('create', ContractModel::class);

        $contract_model = $this->contractModelRepository->make();

        $enterprises = Enterprise::where('is_customer', true)->orderBy('name')->get()
            ->push(Enterprise::where('name', "ADDWORKING")->first())
            ->push(Enterprise::whereName('ADDWORKING DEUTSCHLAND GMBH')->first());

        $enterprises = $enterprises->pluck('name', 'id');

        return view('contract_model::contract_model.create', compact('contract_model', 'enterprises'));
    }

    public function store(StoreContractModelRequest $request)
    {
        $this->authorize('create', ContractModel::class);

        $contract_model = App::make(CreateEmptyContractModel::class)->handle(
            $request->user(),
            $request->input('contract_model')
        );

        return $this->redirectWhen(
            $contract_model->exists,
            route('support.contract.model.show', $contract_model)
        );
    }

    public function show(ContractModel $contract_model)
    {
        $this->authorize('show', $contract_model);

        $contract_model = App::make(ShowContractModel::class)
            ->handle($this->userRepository->connectedUser(), $contract_model);

        return view('contract_model::contract_model.show', compact('contract_model'));
    }

    public function edit(ContractModel $contract_model)
    {
        $this->authorize('edit', $contract_model);

        $enterprises = Enterprise::where('is_customer', true)->orderBy('name')->get()
            ->push(Enterprise::where('name', "ADDWORKING")->first())->pluck('name', 'id');

        return view('contract_model::contract_model.edit', compact('contract_model', 'enterprises'));
    }

    public function update(ContractModel $contract_model, UpdateContractModelRequest $request)
    {
        $this->authorize('edit', $contract_model);

        $contract_model = App::make(EditContractModel::class)->handle(
            $request->user(),
            $contract_model,
            $request->input('contract_model')
        );

        return $this->redirectWhen(
            $contract_model->exists,
            route('support.contract.model.show', $contract_model)
        );
    }

    public function delete(ContractModel $contract_model)
    {
        $this->authorize('delete', $contract_model);

        $deleted = App::make(DeleteContractModel::class)
            ->handle($this->userRepository->connectedUser(), $contract_model);

        return $this->redirectWhen(
            $deleted,
            route('support.contract.model.index')
        );
    }

    public function publish(ContractModel $contract_model, Request $request)
    {
        $this->authorize('publish', $contract_model);

        $contract_model = App::make(PublishContractModel::class)->handle(
            $request->user(),
            $contract_model,
        );

        if (!is_null($contract_model->getVersionningFrom())
            && is_null($contract_model->getVersionningFrom()->getArchivedAt())) {
            App::make(ArchiveContractModel::class)->handle(
                $this->userRepository->connectedUser(),
                $contract_model->getVersionningFrom()
            );
        }

        return $this->redirectWhen(
            $contract_model->exists,
            route('support.contract.model.show', $contract_model)
        );
    }

    public function unpublish(ContractModel $contract_model, Request $request)
    {
        $this->authorize('unpublish', $contract_model);

        $contract_model = App::make(UnpublishContractModel::class)->handle(
            $request->user(),
            $contract_model,
        );

        return $this->redirectWhen(
            $contract_model->exists,
            route('support.contract.model.show', $contract_model)
        );
    }

    public function duplicate(ContractModel $contract_model)
    {
        $this->authorize('duplicate', $contract_model);

        $duplicate_model = App::make(DuplicateContractModel::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_model,
        );

        return $this->redirectWhen(
            $duplicate_model->exists,
            route('support.contract.model.show', $duplicate_model)
        );
    }

    public function versionate(ContractModel $contract_model)
    {
        $this->authorize('versionate', $contract_model);

        $versionate_model = App::make(VersionateContractModel::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_model,
        );

        return $this->redirectWhen(
            $versionate_model->exists,
            route('support.contract.model.show', $versionate_model)
        );
    }

    public function archive(ContractModel $contract_model)
    {
        $this->authorize('archive', $contract_model);

        $archived_contract_model = App::make(ArchiveContractModel::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_model,
        );

        return $this->redirectWhen(
            $archived_contract_model->exists,
            route('support.contract.model.show', $archived_contract_model)
        );
    }
}
