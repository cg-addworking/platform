<?php

namespace App\Http\Controllers\Addworking\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Billing\InboundInvoice\StoreInboundInvoiceRequest;
use App\Http\Requests\Addworking\Billing\InboundInvoice\UpdateInboundInvoiceRequest;
use App\Mail\InboundInvoiceReconciliation;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Repositories\Addworking\Billing\InboundInvoiceItemRepository;
use App\Repositories\Addworking\Billing\InboundInvoiceRepository;
use App\Repositories\Addworking\Enterprise\BillingEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\User\UserRepository;
use Carbon\Carbon;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository
    as BusinessTurnoverEnterpriseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class InboundInvoiceController extends Controller
{
    use HandlesIndex;

    protected $businessTurnoverEnterpriseRepository;
    protected $repository;
    protected $inboundInvoiceItemRepository;
    protected $userRepository;

    public function __construct(
        BusinessTurnoverEnterpriseRepository $businessTurnoverEnterpriseRepository,
        InboundInvoiceRepository $repository,
        InboundInvoiceItemRepository $inboundInvoiceItemRepository,
        UserRepository $userRepository
    ) {
        $this->businessTurnoverEnterpriseRepository = $businessTurnoverEnterpriseRepository;
        $this->repository = $repository;
        $this->inboundInvoiceItemRepository = $inboundInvoiceItemRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [InboundInvoice::class, $enterprise]);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
            if ($enterprise->isVendor()) {
                return $query->ofEnterprise($enterprise);
            } elseif ($enterprise->isCustomer()) {
                return $query->ofCustomer($enterprise);
            }
        });

        return view('addworking.billing.inbound_invoice.index', compact('items', 'enterprise'));
    }

    public function ajaxGetVendorDeadlines(Enterprise $enterprise, Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'customer_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
                $vendor = Enterprise::find($request->vendor_id);
                $customer = Enterprise::find($request->customer_id);

            $vendor_deadlines = app(BillingEnterpriseRepository::class)
                ->getAvailableDeadlinesForCustomer($vendor, $customer);

            $response = [
                'status' => 200,
                'data' => $vendor_deadlines->pluck('display_name', 'id'),
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function ajaxGetTrackingLines(Enterprise $enterprise, Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'customer_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'period_id' => 'required',
        ]);

        if ($request->ajax()) {
            $vendor = Enterprise::find($request->vendor_id);
            $customer = Enterprise::find($request->customer_id);

            $has_invoice_parameter = InvoiceParameter::whereHas('enterprise', function ($query) use ($customer) {
                return $query->where('id', $customer->id);
            })->where('vendor_creating_inbound_invoice_items', true)->isActive()->exists();

            if (! $has_invoice_parameter) {
                $response = [
                    'status' => 200,
                    'data' => ['invoice_parameter' => false],
                ];

                return response()->json($response);
            }

            $period = Carbon::createFromFormat('m/Y', $request->period_id);

            $tracking_lines = MissionTrackingLine::whereHas(
                'missionTracking',
                function ($query) use ($vendor, $customer, $period) {
                    $query->whereHas('milestone', function ($q) use ($period) {
                        $q->where('starts_at', $period->startOfMonth())
                        ->orWhere('ends_at', $period->endOfMonth());
                    })->whereHas('mission', function ($query) use ($vendor, $customer) {
                        $query->ofVendor($vendor)->ofCustomer($customer);
                    });
                }
            )
            ->doesntHave('invoiceItems')
            ->get()
            ->sortByDesc(function ($line) {
                return $line->missionTracking->mission->number;
            });

            $data = [];

            $data['invoice_parameter'] = true;

            foreach ($tracking_lines as $tracking_line) {
                $data['tracking_line'][$tracking_line->id] = [
                    'label' => $tracking_line->label,
                    'quantity' => $tracking_line->quantity,
                    'unit_price' => $tracking_line->unit_price,
                    'amount' => $tracking_line->amount,
                ];
            }

            $data['vat_rate'] = vat_rate([])->get()->sortBy('value')->pluck('display_name', 'id');

            $response = [
                'status' => 200,
                'data' => $data,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function create(Request $request, Enterprise $enterprise, EnterpriseRepository $enterprise_repository)
    {
        $this->authorize('create', [InboundInvoice::class, $enterprise]);

        if (is_null($this->businessTurnoverEnterpriseRepository->getLastYearBusinessTurnover($enterprise)) &&
            ! Session::has('business_turnover_skipped') &&
            $this->businessTurnoverEnterpriseRepository->collectBusinessTurnover($enterprise) &&
            ! $this->userRepository->isSupport(Auth::user())) {
            Session::put(
                'business_turnover_callback_url',
                route('addworking.billing.inbound_invoice.create', $enterprise)
            );

            return Redirect::route('business_turnover.create');
        }

        Session::forget([
            'business_turnover_skipped',
            'business_turnover_callback_url'
        ]);

        $last_month = Carbon::today()->subMonth()->format('m/Y');

        $inbound_invoice = $this->repository
            ->factory([])
            ->enterprise()->associate($enterprise);

        return view('addworking.billing.inbound_invoice.create', compact(
            'enterprise',
            'inbound_invoice',
            'last_month'
        ));
    }

    public function store(StoreInboundInvoiceRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [InboundInvoice::class, $enterprise]);

        $customer = Enterprise::find($request->input('inbound_invoice.customer_id'));

        $has_invoice_parameter = InvoiceParameter::whereHas('enterprise', function ($query) use ($customer) {
            return $query->where('id', $customer->id);
        })->where('vendor_creating_inbound_invoice_items', true)->isActive()->exists();

        $total_of_tracking_lines = 0;
        $selected_tracking_lines = 0;

        if ($has_invoice_parameter && $request->filled('inbound_invoice.items_not_found')) {
            $inbound_invoice = $this->repository->createFromRequest($request, $enterprise);
            Mail::to('facturation+reconciliation@addworking.com')->send(
                new InboundInvoiceReconciliation($inbound_invoice)
            );
            return redirect_when($inbound_invoice->exists, $inbound_invoice->routes->show);
        } elseif ($has_invoice_parameter && $request->filled('inbound_invoice.items')) {
            foreach ($request->input('inbound_invoice.items') as $inbound_invoice_item) {
                if (isset($inbound_invoice_item['invoiceable_id'])) {
                    $model = App::make('laravel-models')->find($inbound_invoice_item['invoiceable_id']);
                    $total_of_tracking_lines += $model->amount;
                    $selected_tracking_lines +=1;
                }
            }

            if ($request->input('inbound_invoice.items') && $selected_tracking_lines == 0) {
                return back()->with('status', [
                    'class' => 'danger',
                    'message' => 'Aucune ligne de suivi de mission sélectionnée!'
                ]);
            }

            if ($request->input('inbound_invoice.amount_before_taxes') == $total_of_tracking_lines) {
                $inbound_invoice = $this->repository->createFromRequest($request, $enterprise);
                $this->inboundInvoiceItemRepository->createFromTrackingLines($request, $inbound_invoice);

                return redirect_when($inbound_invoice->exists, $inbound_invoice->routes->show);
            } else {
                return back()->with('status', ['class' => 'danger', 'message' => 'Montants hors taxes différents!']);
            }
        } else {
            $inbound_invoice = $this->repository->createFromRequest($request, $enterprise);
            return redirect_when($inbound_invoice->exists, $inbound_invoice->routes->show);
        }
    }

    public function show(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('view', $inbound_invoice);

        return view('addworking.billing.inbound_invoice.show', @compact('enterprise', 'inbound_invoice'));
    }

    public function edit(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('edit', $inbound_invoice);

        $last_month = null;

        return view(
            'addworking.billing.inbound_invoice.edit',
            @compact('enterprise', 'inbound_invoice', 'last_month')
        );
    }

    public function update(
        UpdateInboundInvoiceRequest $request,
        Enterprise $enterprise,
        InboundInvoice $inbound_invoice
    ) {
        $this->authorize('edit', $inbound_invoice);

        $inbound_invoice = $this->repository->updateFromRequest($request, $enterprise, $inbound_invoice);

        return redirect_when($inbound_invoice->exists, $inbound_invoice->routes->show);
    }

    public function destroy(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('delete', $inbound_invoice);

        $deleted = $inbound_invoice->delete();

        return redirect_when($deleted, $inbound_invoice->routes->index);
    }

    public function validation(Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('validate', $inbound_invoice);

        $updated = $this->repository->validate($inbound_invoice);

        if ($updated) {
            $this->repository->comment($inbound_invoice);
        }

        return $this->redirectWhen($updated, $inbound_invoice->routes->show);
    }

    public function updateComplianceStatus(Request $request, Enterprise $enterprise, InboundInvoice $inbound_invoice)
    {
        $this->authorize('updateComplianceStatus', InboundInvoice::class);

        $updated = $this->repository->updateComplianceStatusFromRequest($request, $inbound_invoice);

        return $this->redirectWhen($updated, $inbound_invoice->routes->show);
    }
}
