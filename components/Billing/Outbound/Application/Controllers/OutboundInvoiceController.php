<?php

namespace Components\Billing\Outbound\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Builders\InboundInvoiceOfOutboundCsvBuilder;
use Components\Billing\Outbound\Application\Jobs\CreateOutboundInvoiceFromInboundInvoiceJob;
use Components\Billing\Outbound\Application\Jobs\GenerateOutboundInvoiceFileJob;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Requests\StoreOutboundInvoiceFromInboundInvoiceRequest;
use Components\Billing\Outbound\Application\Requests\StoreOutboundInvoiceRequest;
use Components\Billing\Outbound\Application\Requests\UpdateOutboundInvoiceRequest;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\Outbound\Domain\UseCases\AssociateInboundInvoiceToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\CreateOutboundInvoiceForEnterprise;
use Components\Billing\Outbound\Domain\UseCases\DissociateInboundInvoiceFromOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\EditOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\PublishOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\UnpublishOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\ShowOutboundInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutboundInvoiceController extends Controller
{
    protected $outboundInvoiceRepository;
    protected $deadlineRepository;
    protected $inboundInvoiceRepository;
    protected $userRepository;
    protected $outboundInvoiceItemRepository;

    public function __construct(
        OutboundInvoiceRepository $outboundInvoiceRepository,
        DeadlineRepository $deadlineRepository,
        InboundInvoiceRepository $inboundInvoiceRepository,
        UserRepository $userRepository,
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository
    ) {
        $this->outboundInvoiceRepository     = $outboundInvoiceRepository;
        $this->deadlineRepository            = $deadlineRepository;
        $this->inboundInvoiceRepository      = $inboundInvoiceRepository;
        $this->userRepository                = $userRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [OutboundInvoice::class, $enterprise]);

        $outboundInvoice = $this->outboundInvoiceRepository->make();

        $items = $this->outboundInvoiceRepository
            ->list($request->input('filter'), $request->input('search'))
            ->ofCustomer($enterprise)
            ->when(! Auth::user()->isSupport(), function ($query) {
                return $query->where('is_published', true);
            })->latest()
            ->paginate($request->input('per-page') ?: 25);

        return view('outbound_invoice::index', compact('items', 'enterprise', 'outboundInvoice'));
    }

    public function show(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('show', $outboundInvoice);

        $outboundInvoice = App::make(ShowOutboundInvoice::class)
            ->handle($this->userRepository->connectedUser(), $enterprise, $outboundInvoice);

        $payment_orders = $this->outboundInvoiceRepository->getPaymentOrderOfOutboundInvoice($outboundInvoice);

        return view('outbound_invoice::show', compact('enterprise', 'outboundInvoice', 'payment_orders'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', OutboundInvoice::class);

        $outboundInvoice = new OutboundInvoice;

        return view('outbound_invoice::create', compact('enterprise', 'outboundInvoice'));
    }

    public function store(Enterprise $enterprise, StoreOutboundInvoiceRequest $request)
    {
        $data = $request->input();
        $data['outbound_invoice']['enterprise_id'] = $enterprise->id;

        $invoice = App::make(CreateOutboundInvoiceForEnterprise::class)->handle(
            $this->userRepository->connectedUser(),
            $data['outbound_invoice']
        );

        return $this->redirectWhen($invoice->exists, route('addworking.billing.outbound.index', $enterprise));
    }

    public function edit(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('edit', $outboundInvoice);

        return view('outbound_invoice::edit', compact('enterprise', 'outboundInvoice'));
    }

    public function update(
        Enterprise $enterprise,
        OutboundInvoice $outboundInvoice,
        UpdateOutboundInvoiceRequest $request
    ) {
        $this->authorize('edit', $outboundInvoice);

        $authUser = $this->userRepository->connectedUser();

        $invoice = App::make(EditOutboundInvoice::class)
            ->handle($authUser, $enterprise, $outboundInvoice, $request->input('outbound_invoice'));

        return $this->redirectWhen(
            $invoice->exists,
            route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])
        );
    }

    public function indexAssociate(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexAssociate', [OutboundInvoice::class, $enterprise]);

        $items = $this->inboundInvoiceRepository->getInboundInvoicesToAssociate($enterprise, $outboundInvoice);

        return view('outbound_invoice::associate', compact('items', 'enterprise', 'outboundInvoice'));
    }

    public function indexDissociate(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('indexAssociate', [OutboundInvoice::class, $enterprise]);

        $items = $this->inboundInvoiceRepository->getInboundInvoicesToDissociate($enterprise, $outboundInvoice);

        return view('outbound_invoice::dissociate', compact('items', 'enterprise', 'outboundInvoice'));
    }

    public function storeAssociate(Enterprise $enterprise, OutboundInvoice $outboundInvoice, Request $request)
    {
        $this->authorize('storeAssociate', [OutboundInvoice::class, $enterprise]);

        $saved = [];

        if ($request->filled('inbound_invoice.id')) {
            foreach ($request->input('inbound_invoice.id') as $item) {
                $inboundInvoice = $this->inboundInvoiceRepository->find($item);

                $saved[] = App::make(AssociateInboundInvoiceToOutboundInvoice::class)->handle(
                    Auth::user(),
                    $inboundInvoice->enterprise,
                    $inboundInvoice,
                    $enterprise,
                    $outboundInvoice
                );
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route('addworking.billing.outbound.associate', [$enterprise, $outboundInvoice])
        );
    }

    public function storeDissociate(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $this->authorize('storeDissociate', [OutboundInvoice::class, $enterprise]);

        $saved = [];

        if ($request->filled('inbound_invoice.id')) {
            foreach ($request->input('inbound_invoice.id') as $item) {
                $inbound_invoice = $this->inboundInvoiceRepository->find($item);

                $saved[] = App::make(DissociateInboundInvoiceFromOutboundInvoice::class)->handle(
                    $this->userRepository->connectedUser(),
                    $inbound_invoice->enterprise,
                    $inbound_invoice,
                    $enterprise,
                    $outbound_invoice
                );
            }
        }

        return $this->redirectWhen(
            count($saved) > 0,
            route('addworking.billing.outbound.dissociate', [$enterprise, $outbound_invoice])
        );
    }

    public function createGenerateFile(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('generateFile', [OutboundInvoice::class, $enterprise, $outboundInvoice]);

        return view('outbound_invoice::generate_file', compact('enterprise', 'outboundInvoice'));
    }

    public function storeGenerateFile(Enterprise $enterprise, OutboundInvoice $outbound_invoice, Request $request)
    {
        $this->authorize('generateFile', [OutboundInvoice::class, $enterprise, $outbound_invoice]);

        GenerateOutboundInvoiceFileJob::dispatch(
            $this->userRepository->connectedUser(),
            $enterprise,
            $outbound_invoice,
            $request->input('outbound_invoice')
        );

        return $this->redirectWhen(
            true,
            route('addworking.billing.outbound.show', [$enterprise, $outbound_invoice]),
            "Génération de la facture en cours, veuillez rafraichir la page dans quelques instants."
        );
    }

    public function publish(Enterprise $enterprise, OutboundInvoice $outbound_invoice)
    {
        $updated = App::make(PublishOutboundInvoice::class)->handle(
            $this->userRepository->connectedUser(),
            $outbound_invoice
        );

        return $this->redirectWhen($updated, route('addworking.billing.outbound.index', $enterprise));
    }

    public function unpublish(Enterprise $enterprise, OutboundInvoice $outbound_invoice)
    {
        $updated = App::make(UnpublishOutboundInvoice::class)->handle(
            $this->userRepository->connectedUser(),
            $outbound_invoice
        );

        return $this->redirectWhen($updated, route('addworking.billing.outbound.index', $enterprise));
    }

    public function export(
        Enterprise $enterprise,
        OutboundInvoice $outbound_invoice,
        InboundInvoiceOfOutboundCsvBuilder $builder
    ) {
        $this->authorize('export', [get_class($outbound_invoice), $enterprise]);

        $items = OutboundInvoiceItem::with(['outboundInvoice', 'inboundInvoiceItem.inboundInvoice'])
        ->whereHas('outboundInvoice', function ($query) use ($outbound_invoice) {
            $query->where('id', $outbound_invoice->id);
        })->get()
        ->sortBy(function ($item) {
            return $item->getInboundInvoice()->number;
        })->sortBy(function ($item) {
            return $item->getInboundInvoice()->enterprise->name;
        });

        return $builder->addAll($items)->download();
    }

    public function createFromInboundInvoice(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('createFromInboundInvoice', [OutboundInvoice::class, $inbound_invoice]);

        return view('outbound_invoice::create_from_inbound_invoice', compact('enterprise', 'inbound_invoice'));
    }

    public function storeFromInboundInvoice(
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice,
        StoreOutboundInvoiceFromInboundInvoiceRequest $request
    ) {
        $this->authorize('createFromInboundInvoice', [OutboundInvoice::class, $inbound_invoice]);

        $data = $request->input();
        $data['outbound_invoice']['enterprise_id'] = $enterprise->id;

        $invoice = CreateOutboundInvoiceFromInboundInvoiceJob::dispatchNow(
            $this->userRepository->connectedUser(),
            $inbound_invoice,
            $data['outbound_invoice']
        );

        return $this->redirectWhen(
            $invoice->exists,
            route('addworking.billing.outbound.show', [$enterprise, $invoice])
        );
    }

    public function search(Request $request)
    {
        $this->authorize('search', OutboundInvoice::class);

        $result = [];
        $search = $request->input('number');

        $invoices = OutboundInvoice::orderBy('number', 'asc')
            ->limit(15)
            ->where('number', 'LIKE', $search."%")
            ->get();

        foreach ($invoices as $invoice) {
            $result[$invoice->getId()] = $invoice->getlabel();
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'body' => $result,
        ]);
    }

    /**
     * @param Enterprise $enterprise
     * @param OutboundInvoice $outboundInvoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceCreationFailedException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateInvoice(Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        $this->authorize('validate', $outboundInvoice);

        $auth_user = App::make(UserRepositoryInterface::class)->connectedUser();

        $outboundInvoice = $this->outboundInvoiceRepository->validate($auth_user, $outboundInvoice);

        return $this->redirectWhen(
            $outboundInvoice->exists,
            route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])
        );
    }
}
