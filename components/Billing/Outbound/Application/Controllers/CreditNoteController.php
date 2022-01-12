<?php

namespace Components\Billing\Outbound\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditLineForOutboundInvoiceItem;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditNoteForOutboundInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CreditNoteController extends Controller
{
    protected $feeRepository;
    protected $outboundInvoiceItemRepository;
    protected $userRepository;

    public function __construct(
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository,
        FeeRepository $feeRepository,
        UserRepository $userRepository
    ) {
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
        $this->feeRepository = $feeRepository;
        $this->userRepository = $userRepository;
    }

    public function store(Enterprise $enterprise, OutboundInvoice $outbound_invoice)
    {
        $invoice = App::make(CreateCreditNoteForOutboundInvoice::class)->handle(
            $this->userRepository->connectedUser(),
            $outbound_invoice
        );

        return $this->redirectWhen(
            $invoice->exists,
            route('addworking.billing.outbound.credit_note.index_associate', [$enterprise, $invoice])
        );
    }

    public function index(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexCreditLine', [OutboundInvoice::class, $enterprise]);

        $items = $this->outboundInvoiceItemRepository->getItemsOfOutboundInvoice($outboundInvoice);

        return view(
            'outbound_invoice::item.index_credit_line',
            compact('items', 'enterprise', 'outboundInvoice')
        );
    }

    public function indexAssociate(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexCreditLine', [OutboundInvoice::class, $enterprise]);

        $parentOutboundInvoice = $outboundInvoice->getParent();

        $items = $this->outboundInvoiceItemRepository->getItemsToAssociate($parentOutboundInvoice);

        return view(
            'outbound_invoice::item.associate_credit_line',
            compact('items', 'enterprise', 'outboundInvoice', 'parentOutboundInvoice')
        );
    }

    public function associate(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $saved = [];

        if ($request->filled('outbound_invoice_item.id')) {
            foreach ($request->input('outbound_invoice_item.id') as $item) {
                $outbound_invoice_item = ($this->outboundInvoiceItemRepository->find($item));

                $saved[] = App::make(CreateCreditLineForOutboundInvoiceItem::class)->handle(
                    $this->userRepository->connectedUser(),
                    $outbound_invoice,
                    $outbound_invoice_item
                );
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route('addworking.billing.outbound.credit_note.index', [$enterprise, $outbound_invoice])
        );
    }

    public function indexFees(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexCreditLine', [OutboundInvoice::class, $enterprise]);

        $items = $this->feeRepository->getFeesOfOutboundInvoice($outboundInvoice);

        return view(
            'outbound_invoice::fee.index_credit_fees',
            compact('items', 'enterprise', 'outboundInvoice')
        );
    }

    public function indexAssociateFees(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexCreditLine', [OutboundInvoice::class, $enterprise]);

        $parentOutboundInvoice = $outboundInvoice->getParent();

        $items = $this->feeRepository->getFeesToAssociate($parentOutboundInvoice);

        return view(
            'outbound_invoice::fee.associate_credit_fees',
            compact('items', 'enterprise', 'outboundInvoice', 'parentOutboundInvoice')
        );
    }

    public function associateFees(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $saved = [];

        if ($request->filled('fee.id')) {
            foreach ($request->input('fee.id') as $item) {
                $fee = $this->feeRepository->find($item);

                $saved[] = App::make(CreateCreditAddworkingFees::class)->handle(
                    $this->userRepository->connectedUser(),
                    $fee,
                    $outbound_invoice
                );
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route('addworking.billing.outbound.credit_note.index_fees', [$enterprise, $outbound_invoice])
        );
    }
}
