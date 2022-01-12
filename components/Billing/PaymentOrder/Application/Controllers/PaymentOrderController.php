<?php

namespace Components\Billing\PaymentOrder\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Application\Requests\StorePaymentOrderRequest;
use Components\Billing\PaymentOrder\Application\Requests\UpdatePaymentOrderRequest;
use Components\Billing\PaymentOrder\Domain\UseCases\AssociateInvoiceToPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\CreatePaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\DeletePaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\DissociateInvoiceFromPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\EditPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\GeneratePaymentOrderFile;
use Components\Billing\PaymentOrder\Domain\UseCases\ListPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\MarkPaymentOrderAsPaid;
use Components\Billing\PaymentOrder\Domain\UseCases\ShowPaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PaymentOrderController extends Controller
{
    protected $paymentOrderRepository;
    protected $outboundInvoiceRepository;
    protected $inboundInvoiceRepository;
    protected $userRepository;

    public function __construct(
        PaymentOrderRepository $paymentOrderRepository,
        OutboundInvoiceRepository $outboundInvoiceRepository,
        InboundInvoiceRepository $inboundInvoiceRepository,
        UserRepository $userRepository
    ) {
        $this->paymentOrderRepository = $paymentOrderRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->inboundInvoiceRepository = $inboundInvoiceRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $items = App::make(ListPaymentOrder::class)
            ->handle($this->userRepository->connectedUser(), $enterprise);

        return view('payment_order::payment_order.index', compact('items', 'enterprise'));
    }

    public function show(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('show', $payment_order);

        $payment_order = App::make(ShowPaymentOrder::class)
            ->handle($this->userRepository->connectedUser(), $payment_order);

        $outbound_invoices = $this->paymentOrderRepository->getOutboundInvoices($payment_order);

        return view('payment_order::payment_order.show', compact('enterprise', 'payment_order', 'outbound_invoices'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', PaymentOrder::class);

        $payment_order = new PaymentOrder();

        $addworking_ibans = App::make(IbanRepository::class)
            ->getAllIbansOf(App::make(EnterpriseRepository::class)->findByName("ADDWORKING"))
            ->pluck('formatted_label', 'id');

        return view('payment_order::payment_order.create', compact('enterprise', 'payment_order', 'addworking_ibans'));
    }

    public function store(Enterprise $enterprise, StorePaymentOrderRequest $request)
    {
        $this->authorize('create', PaymentOrder::class);

        $payment_order = App::make(CreatePaymentOrder::class)
            ->handle(
                $request->user(),
                $enterprise,
                $request->input('payment_order')
            );

        return $this->redirectWhen($payment_order->exists, $payment_order->routes->show);
    }

    public function edit(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('edit', PaymentOrder::class);

        $addworking_ibans = App::make(IbanRepository::class)
            ->getAllIbansOf(App::make(EnterpriseRepository::class)->findByName("ADDWORKING"))
            ->pluck('formatted_label', 'id');

        return view(
            'payment_order::payment_order.edit',
            compact('enterprise', 'payment_order', 'addworking_ibans')
        );
    }

    public function update(Enterprise $enterprise, PaymentOrder $payment_order, UpdatePaymentOrderRequest $request)
    {
        $this->authorize('edit', PaymentOrder::class);

        $payment_order = App::make(EditPaymentOrder::class)
            ->handle(
                $request->user(),
                $payment_order,
                $request->input('payment_order')
            );

        return $this->redirectWhen($payment_order->exists, $payment_order->routes->show);
    }

    public function indexAssociate(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('associate', $payment_order);

        $items = $this->paymentOrderRepository->getInboundInvoiceToAssociate($enterprise);

        return view(
            'payment_order::payment_order.associate',
            compact('enterprise', 'payment_order', 'items')
        );
    }

    public function storeAssociate(Enterprise $enterprise, PaymentOrder $payment_order, Request $request)
    {
        $this->authorize('associate', $payment_order);

        $saved = [];

        if ($request->filled('inbound_invoice.id')) {
            foreach ($request->input('inbound_invoice.id') as $id) {
                $inbound_invoice = $this->inboundInvoiceRepository->find($id);
                $saved[] = App::make(AssociateInvoiceToPaymentOrder::class)
                    ->handle(Auth::user(), $inbound_invoice, $payment_order);
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route(
                'addworking.billing.payment_order.index_associate',
                [$enterprise, $payment_order]
            )
        );
    }

    public function indexDissociate(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('dissociate', $payment_order);

        $items = $this->paymentOrderRepository->getAssociatedInboundInvoices($payment_order);

        return view(
            'payment_order::payment_order.dissociate',
            compact('enterprise', 'payment_order', 'items')
        );
    }

    public function storeDissociate(Enterprise $enterprise, PaymentOrder $payment_order, Request $request)
    {
        $this->authorize('storeDissociate', $payment_order);

        $saved = [];

        if ($request->filled('inbound_invoice.id')) {
            foreach ($request->input('inbound_invoice.id') as $id) {
                $inbound_invoice = $this->inboundInvoiceRepository->find($id);
                $saved[] = App::make(DissociateInvoiceFromPaymentOrder::class)
                    ->handle(Auth::user(), $inbound_invoice, $payment_order);
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route(
                'addworking.billing.payment_order.index_dissociate',
                [$enterprise, $payment_order]
            )
        );
    }

    public function generate(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('generate', $payment_order);

        $generated = App::make(GeneratePaymentOrderFile::class)
            ->handle(Auth::user(), $payment_order);

        return $this->redirectWhen(
            $generated,
            route('addworking.billing.payment_order.show', [$enterprise, $payment_order])
        );
    }

    public function execute(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('execute', $payment_order);

        $saved = App::make(MarkPaymentOrderAsPaid::class)
            ->handle(Auth::user(), $payment_order);

        return $this->redirectWhen(
            $saved->getStatus() == PaymentOrder::STATUS_EXECUTED,
            route('addworking.billing.payment_order.show', [$enterprise, $payment_order])
        );
    }

    public function destroy(Enterprise $enterprise, PaymentOrder $payment_order)
    {
        $this->authorize('delete', $payment_order);

        $deleted = App::make(DeletePaymentOrder::class)
            ->handle(Auth::user(), $payment_order);

        return $this->redirectWhen(
            $deleted,
            route('addworking.billing.payment_order.index', $enterprise)
        );
    }
}
