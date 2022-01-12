<?php

namespace App\Http\Controllers\Addworking\Billing;

use App\Http\Requests\Addworking\Billing\InboundInvoiceItem\StoreInboundInvoiceItemRequest;
use App\Http\Requests\Addworking\Billing\InboundInvoiceItem\UpdateInboundInvoiceItemRequest;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Repositories\Addworking\Billing\InboundInvoiceItemRepository;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class InboundInvoiceItemController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(InboundInvoiceItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise, InboundInvoice $inbound_invoice, Request $request)
    {
        $this->authorize('index', [InboundInvoiceItem::class, $inbound_invoice]);

        $items = InboundInvoiceItem::whereInboundInvoice($inbound_invoice)->get()->sortByDesc(function ($query) {
            if (! is_null($query->invoiceable)
                && $query->invoiceable->missionTracking
                && $query->invoiceable->missionTracking->mission
            ) {
                return $query->invoiceable->missionTracking->mission->number;
            }
        });

        return view(
            'addworking.billing.inbound_invoice_item.index',
            @compact('enterprise', 'inbound_invoice', 'items')
        );
    }

    public function create(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('create', [InboundInvoiceItem::class, $inbound_invoice]);

        $inbound_invoice_item = $this->repository->factory()->invoice()->associate($inbound_invoice);

        return view(
            'addworking.billing.inbound_invoice_item.create',
            @compact('enterprise', 'inbound_invoice', 'inbound_invoice_item')
        );
    }

    public function store(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        StoreInboundInvoiceItemRequest $request
    ) {
        $this->authorize('create', [InboundInvoiceItem::class, $inbound_invoice]);

        $inbound_invoice_item = $this->repository->createFromRequest($request, $inbound_invoice);

        return $this->redirectWhen($inbound_invoice_item->exists, $inbound_invoice_item->routes->index);
    }

    public function show(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        InboundInvoiceItem $inbound_invoice_item
    ) {
        $this->authorize('show', $inbound_invoice_item);

        return view(
            'addworking.billing.inbound_invoice_item.show',
            @compact('enterprise', 'inbound_invoice', 'inbound_invoice_item')
        );
    }

    public function edit(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        InboundInvoiceItem $inbound_invoice_item
    ) {
        $this->authorize('edit', $inbound_invoice_item);

        return view(
            'addworking.billing.inbound_invoice_item.edit',
            @compact('enterprise', 'inbound_invoice', 'inbound_invoice_item')
        );
    }

    public function update(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        InboundInvoiceItem $inbound_invoice_item,
        UpdateInboundInvoiceItemRequest $request
    ) {
        $this->authorize('edit', $inbound_invoice_item);

        $inbound_invoice_item = $this->repository->updateFromRequest($request, $inbound_invoice_item);

        return $this->redirectWhen($inbound_invoice_item->exists, $inbound_invoice_item->routes->index);
    }

    public function destroy(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        InboundInvoiceItem $inbound_invoice_item
    ) {
        $this->authorize('destroy', $inbound_invoice_item);

        $deleted = $this->repository->delete($inbound_invoice_item);

        return $this->redirectWhen($deleted, $inbound_invoice_item->routes->index);
    }

    public function createFromTrackingLines(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        MissionTrackingLineRepository $mission_tracking_line_repository
    ) {
        $this->authorize('create', [InboundInvoiceItem::class, $inbound_invoice]);

        $inbound_invoice_item = $this->repository->make()->invoice()->associate($inbound_invoice);
        $tracking_lines = $mission_tracking_line_repository->getLinesFromInboundInvoice($inbound_invoice);

        return view(
            'addworking.billing.inbound_invoice_item.create_from_tracking_lines',
            @compact('enterprise', 'inbound_invoice', 'inbound_invoice_item', 'tracking_lines')
        );
    }

    public function storeFromTrackingLines(Request $request, Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('create', [InboundInvoiceItem::class, $inbound_invoice]);

        if (! empty($request->input('inbound_invoice.items'))) {
            $this->repository->createFromTrackingLines($request, $inbound_invoice);
        }

        return $this->redirectWhen(
            $inbound_invoice->items->count(),
            (new InboundInvoiceItem)->routes->index(@compact('enterprise', 'inbound_invoice')),
            null,
            "Aucune ligne associée"
        );
    }
}
