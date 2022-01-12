<?php

namespace Components\Billing\Outbound\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Builders\FeesCsvBuilder;
use Components\Billing\Outbound\Application\Jobs\CalculateAddworkingFeesJob;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\UseCases\CalculateAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\DeleteCreditAddworkingFeeFromCreditNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    protected $feeRepository;
    protected $outboundInvoiceRepository;
    protected $userRepository;

    public function __construct(
        FeeRepository $feeRepository,
        OutboundInvoiceRepository $outboundInvoiceRepository,
        UserRepository $userRepository
    ) {
        $this->feeRepository = $feeRepository;
        $this->userRepository = $userRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
    }

    public function index(Enterprise $enterprise, OutboundInvoice $outboundInvoice, Request $request)
    {
        $this->authorize('index', [Fee::class, $enterprise, $outboundInvoice]);

        $items = $this->feeRepository
            ->list($request->input('filter'), $request->input('search'))
            ->ofOutboundInvoice($outboundInvoice)
            ->orderBy('type', 'desc')->orderBy('vendor_id')
            ->paginate(25);

        return view('outbound_invoice::fee.index', compact('items', 'enterprise', 'outboundInvoice'));
    }

    public function create(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('create', [Fee::class, $enterprise, $outboundInvoice]);
        
        $fee = $this->feeRepository->make();

        return view('outbound_invoice::fee.create', compact('enterprise', 'outboundInvoice', 'fee'));
    }

    public function store(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $fee = App::make(CreateAddworkingFees::class)->handle(
            $this->userRepository->connectedUser(),
            $outbound_invoice,
            $request->input('fee')
        );

        return $this->redirectWhen(
            $fee->exists,
            route('addworking.billing.outbound.fee.index', [$enterprise, $outbound_invoice])
        );
    }

    public function createCalculate(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('create', [Fee::class, $enterprise, $outboundInvoice]);

        $fee = new Fee;

        return view('outbound_invoice::fee.calculate', compact('enterprise', 'outboundInvoice', 'fee'));
    }

    public function storeCalculate(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $outbound_invoice_output = $this->outboundInvoiceRepository
            ->find($request->input('outbound_invoice_number'));

        CalculateAddworkingFeesJob::dispatch(
            $this->userRepository->connectedUser(),
            $enterprise,
            $outbound_invoice,
            $outbound_invoice_output
        );

        return $this->redirectWhen(
            true,
            route('addworking.billing.outbound.fee.index', [$enterprise, $request->input('outbound_invoice_number')]),
            "Calcul des commissions en cours, veuillez rafraichir la page dans quelques instants."
        );
    }

    public function delete(Enterprise $enterprise, OutboundInvoice $outboundInvoice, Fee $fee)
    {
        $this->authorize('delete', $fee);

        $deleted = App::make(DeleteCreditAddworkingFeeFromCreditNote::class)->handle(
            $this->userRepository->connectedUser(),
            $fee,
            $outboundInvoice
        );
        
        return $this->redirectWhen(
            $deleted,
            route('addworking.billing.outbound.credit_note.index_fees', [$enterprise, $outboundInvoice])
        );
    }

    public function export(Enterprise $enterprise, OutboundInvoice $outboundInvoice, FeesCsvBuilder $builder)
    {
        $this->authorize('export', Fee::class);

        $items = $this->feeRepository
            ->list()
            ->ofOutboundInvoice($outboundInvoice)
            ->get();

        return $builder->addAll($items)->download();
    }
}
