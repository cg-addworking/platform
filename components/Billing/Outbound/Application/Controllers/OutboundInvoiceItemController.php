<?php

namespace Components\Billing\Outbound\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Requests\StoreOutboundInvoiceItemRequest;
use Components\Billing\Outbound\Domain\UseCases\AddAdHocLineToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\DeleteAdHocLineFromOutboundInvoice;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class OutboundInvoiceItemController extends Controller
{
    protected $outboundInvoiceItemRepository;
    protected $userRepository;

    public function __construct(
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository,
        UserRepository $userRepository
    ) {
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('index', [OutboundInvoiceItem::class, $enterprise, $outboundInvoice]);

        $outboundInvoiceItem = $this->outboundInvoiceItemRepository->make();

        $items = $outboundInvoice->items()->paginate(25);

        return view(
            'outbound_invoice::item.index',
            compact('enterprise', 'outboundInvoice', 'outboundInvoiceItem', 'items')
        );
    }

    public function create(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('create', [OutboundInvoiceItem::class, $enterprise, $outboundInvoice]);

        $outboundInvoiceItem = new OutboundInvoiceItem;
        
        return view('outbound_invoice::item.create', compact('enterprise', 'outboundInvoice', 'outboundInvoiceItem'));
    }

    public function store(
        Enterprise $enterprise,
        OutboundInvoice $outboundInvoice,
        StoreOutboundInvoiceItemRequest $request
    ) {
        $data = $request->input();

        $item = App::make(AddAdHocLineToOutboundInvoice::class)->handle(
            Auth::user(),
            $enterprise,
            $outboundInvoice,
            $data['outbound_invoice_item']
        );

        return $this->redirectWhen(
            $item->exists,
            route('addworking.billing.outbound.item.index', [$enterprise, $outboundInvoice])
        );
    }

    public function delete(
        Enterprise $enterprise,
        OutboundInvoice $outbound_invoice,
        OutboundInvoiceItem $outbound_invoice_item
    ) {
        $this->authorize('delete', $outbound_invoice_item);

        $deleted = App::make(DeleteAdHocLineFromOutboundInvoice::class)->handle(
            $this->userRepository->connectedUser(),
            $outbound_invoice,
            $outbound_invoice_item
        );
        
        return $this->redirectWhen(
            $deleted,
            route('addworking.billing.outbound.item.index', [$enterprise, $outbound_invoice])
        );
    }
}
