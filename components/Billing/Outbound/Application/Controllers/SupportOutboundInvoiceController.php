<?php

namespace Components\Billing\Outbound\Application\Controllers;

use Components\Billing\Outbound\Application\Controllers\OutboundInvoiceController;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Illuminate\Http\Request;

class SupportOutboundInvoiceController extends OutboundInvoiceController
{
    protected $outboundInvoiceRepository;
    protected $deadlineRepository;
    protected $inboundInvoiceRepository;
    protected $userRespository;
    protected $outboundInvoiceItemRepository;

    public function __construct(
        OutboundInvoiceRepository $outboundInvoiceRepository,
        DeadlineRepository $deadlineRepository,
        InboundInvoiceRepository $inboundInvoiceRepository,
        UserRepository $userRepository,
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository
    ) {
        parent::__construct(
            $outboundInvoiceRepository,
            $deadlineRepository,
            $inboundInvoiceRepository,
            $userRepository,
            $outboundInvoiceItemRepository
        );
    }

    public function index(Request $request, $enterprise = null)
    {
        $this->authorize('indexSupport', OutboundInvoice::class);

        $outboundInvoice = $this->outboundInvoiceRepository->make();

        $items = $this->outboundInvoiceRepository
            ->list($request->input('filter'), $request->input('search'))
            ->latest()
            ->paginate($request->input('per-page') ?: 25);

        return view('outbound_invoice::support.index', compact('items', 'outboundInvoice'));
    }
}
