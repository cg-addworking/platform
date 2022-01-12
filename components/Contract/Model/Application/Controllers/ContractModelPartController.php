<?php

namespace Components\Contract\Model\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Application\Requests\StoreContractModelPartRequest;
use Components\Contract\Model\Application\Requests\UpdateContractModelPartRequest;
use Components\Contract\Model\Domain\UseCases\CreateContractModelPart;
use Components\Contract\Model\Domain\UseCases\CreateContractModelPartPreview;
use Components\Contract\Model\Domain\UseCases\EditContractModelPart;
use Components\Contract\Model\Domain\UseCases\ListContractModelPart;
use Components\Contract\Model\Domain\UseCases\DeleteContractModelPart;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContractModelPartController extends Controller
{
    protected $contractModelPartRepository;
    protected $userRepository;

    public function __construct(
        ContractModelPartRepository $contractModelPartRepository,
        UserRepository $userRepository
    ) {
        $this->contractModelPartRepository = $contractModelPartRepository;
        $this->userRepository = $userRepository;
    }

    public function index(ContractModel $contract_model)
    {
        $this->authorize('index', ContractModelPart::class);

        $items = App::make(ListContractModelPart::class)->handle(
            Auth::User(),
            $contract_model
        );

        return view('contract_model::contract_model_part.index', compact('items', 'contract_model'));
    }

    public function create(ContractModel $contract_model)
    {
        $this->authorize('create', [ContractModelPart::class, $contract_model]);

        $contract_model_part = $this->contractModelPartRepository->make();

        $order = $contract_model->getParts()->count() + 1;

        return view(
            'contract_model::contract_model_part.create',
            compact('order', 'contract_model_part', 'contract_model')
        );
    }

    public function store(StoreContractModelPartRequest $request, ContractModel $contract_model)
    {
        $this->authorize('create', [ContractModelPart::class, $contract_model]);

        $contract_model_part = App::make(CreateContractModelPart::class)->handle(
            $request->user(),
            $contract_model,
            $request->input('contract_model_part'),
            $request->file('contract_model_part.file')
        );

        if ($contract_model_part->getShouldCompile() && $contract_model_part->getVariables()->isNotEmpty()) {
            return $this->redirectWhen(
                $contract_model_part->exists,
                route('support.contract.model.variable.edit', $contract_model)
            );
        }

        return $this->redirectWhen(
            $contract_model_part->exists,
            route('support.contract.model.part.index', $contract_model)
        );
    }

    public function edit(ContractModel $contract_model, ContractModelPart $contract_model_part)
    {
        $this->authorize('edit', $contract_model_part);

        return view('contract_model::contract_model_part.edit', compact('contract_model', 'contract_model_part'));
    }

    public function update(
        UpdateContractModelPartRequest $request,
        ContractModel $contract_model,
        ContractModelPart $contract_model_part
    ) {
        $this->authorize('edit', $contract_model_part);

        $contract_model_part = App::make(EditContractModelPart::class)->handle(
            $request->user(),
            $contract_model_part,
            $request->input('contract_model_part'),
            $request->file('contract_model_part.file')
        );

        return $this->redirectWhen(
            $contract_model_part->exists,
            route('support.contract.model.part.index', $contract_model)
        );
    }

    public function delete(ContractModel $contract_model, ContractModelPart $contract_model_part)
    {
        $this->authorize('edit', $contract_model_part);

        $deleted = App::make(DeleteContractModelPart::class)
            ->handle(Auth::User(), $contract_model_part);

        return $this->redirectWhen(
            $deleted,
            route('support.contract.model.part.index', $contract_model)
        );
    }

    public function preview(ContractModel $contract_model, ContractModelPart $contract_model_part)
    {
        $this->authorize('preview', $contract_model_part);

        return App::make(CreateContractModelPartPreview::class)
            ->handle($this->userRepository->connectedUser(), $contract_model_part);
    }

    public function wysiwygPreview(Request $request, ContractModel $contract_model)
    {
        $this->authorize('create', [ContractModelPart::class, $contract_model]);
        $request->validate([
            'content' => 'required'
        ]);

        if ($request->ajax()) {
            $text = $request->get('content');

            $html = $this->contractModelPartRepository->formatTextForPdf($text);

            $pdf = App::make(PdfManager::class)->htmlToPdf($html, "preview");

            return response()->json([
                'status' => 200,
                'data' => base64_encode($pdf->output()),
            ]);
        }
        abort(501);
    }
}
