<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Application\Presenters\CaptureInvoicePresenter;
use Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\UseCases\CreateCaptureInvoice;
use Components\Contract\Contract\Domain\UseCases\DeleteCaptureInvoice;
use Components\Contract\Contract\Domain\UseCases\EditCaptureInvoice;
use Components\Contract\Contract\Domain\UseCases\ListCaptureInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CaptureInvoiceController extends Controller
{
    private $contractPartyRepository;
    private $userRepository;
    private $captureInvoiceRepository;

    public function __construct(
        ContractPartyRepository $contractPartyRepository,
        UserRepository $userRepository,
        CaptureInvoiceRepository $captureInvoiceRepository
    ) {
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
        $this->captureInvoiceRepository = $captureInvoiceRepository;
    }

    public function index(Contract $contract)
    {
        $this->authorize('create', CaptureInvoice::class);

        $user = $this->userRepository->connectedUser();

        $presenter = new CaptureInvoicePresenter();

        $items = App::make(ListCaptureInvoice::class)
            ->handle($presenter, $user, $contract);

        return view('contract::capture_invoice.index', compact('items', 'contract'));
    }

    public function create(Contract $contract)
    {
        $this->authorize('create', CaptureInvoice::class);

        $capture_invoice = $this->captureInvoiceRepository->make();
        $contract_party = $this->contractPartyRepository->getFirstSigningParty($contract);
        $vendor = Enterprise::find($contract_party->getEnterprise()->id);
        $guaranteed_holdback = ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'retenue_garantie');
        })->first()->value ?? 'n/a';

        return view(
            'contract::capture_invoice.create',
            compact('vendor', 'contract', 'guaranteed_holdback', 'capture_invoice')
        );
    }

    public function store(Contract $contract, Request $request)
    {
        $this->authorize('create', CaptureInvoice::class);

        $invoice = App::make(CreateCaptureInvoice::class)->handle(
            $request->user(),
            $contract,
            $request->input('capture_invoice'),
            $request->file('capture_invoice.dc4_file')
        );

        return $this->redirectWhen($invoice->exists, route('contract_accounting_monitoring.index', $contract));
    }

    public function delete(Contract $contract, CaptureInvoice $capture_invoice)
    {
        $this->authorize('delete', $capture_invoice);

        $deleted = App::make(DeleteCaptureInvoice::class)
            ->handle($this->userRepository->connectedUser(), $capture_invoice);

        return $this->redirectWhen($deleted, route('contract_accounting_monitoring.index', $contract));
    }

    public function edit(Contract $contract, CaptureInvoice $capture_invoice)
    {
        $this->authorize('edit', $capture_invoice);

        $contract_party = $this->contractPartyRepository->getFirstSigningParty($contract);
        $vendor = Enterprise::find($contract_party->getEnterprise()->id);
        $guaranteed_holdback = ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'retenue_garantie');
        })->first()->value ?? 'n/a';
        $page = "edit";


        return view(
            'contract::capture_invoice.edit',
            compact('contract', 'capture_invoice', 'vendor', 'guaranteed_holdback')
        );
    }

    public function update(Contract $contract, CaptureInvoice $capture_invoice, Request $request)
    {
        $this->authorize('edit', $capture_invoice);

        $invoice = App::make(EditCaptureInvoice::class)->handle(
            $request->user(),
            $contract,
            $capture_invoice,
            $request->input('capture_invoice'),
            $request->file('capture_invoice.dc4_file')
        );

        return $this->redirectWhen($invoice->exists, route('contract_accounting_monitoring.index', $contract));
    }
}
