<?php
namespace Components\Billing\PaymentOrder\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\CsvLoaderReport;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Loaders\ReceivedPaymentCsvLoader;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\UseCases\CreateReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\DeleteReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\EditReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPaymentAsSupport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReceivedPaymentController extends Controller
{
    private $userRepository;
    private $receivedPaymentRepository;

    public function __construct(
        UserRepository $userRepository,
        ReceivedPaymentRepository $receivedPaymentRepository
    ) {
        $this->userRepository = $userRepository;
        $this->receivedPaymentRepository = $receivedPaymentRepository;
    }

    public function index(Enterprise $enterprise)
    {
        $this->authorize('index', ReceivedPayment::class);

        $items = App::make(ListReceivedPayment::class)->handle($this->userRepository->connectedUser(), $enterprise);

        return view('payment_order::received_payment.index', compact('enterprise', 'items'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', ReceivedPayment::class);

        $received_payment = $this->receivedPaymentRepository->make();

        $addworkingIbans = App::make(IbanRepository::class)
            ->getAllIbansOf(App::make(EnterpriseRepository::class)->findByName("ADDWORKING"))
            ->pluck('formatted_label', 'id');

        return view(
            'payment_order::received_payment.create',
            compact('enterprise', 'received_payment', 'addworkingIbans')
        );
    }

    public function store(Enterprise $enterprise, Request $request)
    {
        $request->validate([
            'received_payment.iban' => 'required|uuid|exists:addworking_enterprise_ibans,id'
        ]);

        $payment = App::make(CreateReceivedPayment::class)->handle(
            $this->userRepository->connectedUser(),
            $enterprise,
            $request->input('received_payment')
        );

        return $this->redirectWhen($payment->exists, route(
            'addworking.billing.received_payment.index',
            $enterprise
        ));
    }

    public function edit(Enterprise $enterprise, ReceivedPayment $received_payment)
    {
        $this->authorize('edit', $received_payment);

        $addworkingIbans = App::make(IbanRepository::class)
            ->getAllIbansOf(App::make(EnterpriseRepository::class)->findByName("ADDWORKING"))
            ->pluck('formatted_label', 'id');

        return view(
            'payment_order::received_payment.edit',
            compact('enterprise', 'addworkingIbans', 'received_payment')
        );
    }

    public function update(Enterprise $enterprise, ReceivedPayment $received_payment, Request $request)
    {
        $payment = App::make(EditReceivedPayment::class)->handle(
            $this->userRepository->connectedUser(),
            $received_payment,
            $request->input('received_payment')
        );

        return $this->redirectWhen($payment->exists, route(
            'addworking.billing.received_payment.index',
            $enterprise
        ));
    }

    public function searchOutboundInvoice(Request $request, Enterprise $enterprise)
    {
        $this->authorize('create', ReceivedPayment::class);

        $result = [];
        $search = $request->input('number');

        $invoices = OutboundInvoice::whereHas('enterprise', function ($query) use ($enterprise) {
            $enterprises = app()->make(FamilyEnterpriseRepository::class)->getDescendants($enterprise, true);
            return $query->whereIn('id', $enterprises->pluck('id'));
        })->whereNotIn('status', [OutboundInvoice::STATUS_FULLY_PAID, 'paid'])
            ->where('created_at', '>', Carbon::today()->startOfMonth()->subMonths(6)->toDateString())
            ->orderBy('number', 'asc')
            ->where('number', 'LIKE', $search."%")
            ->limit(15)
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

    public function indexSupport()
    {
        $this->authorize('indexSupport', ReceivedPayment::class);

        $items = App::make(ListReceivedPaymentAsSupport::class)->handle($this->userRepository->connectedUser());

        return view('payment_order::received_payment.support_index', compact('items'));
    }

    public function import(Enterprise $enterprise)
    {
        return view('payment_order::received_payment.import', compact('enterprise'));
    }

    public function load(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:4000|min:1',
        ]);

        $file   = File::from($request->file('file'))->saveAndGet();
        $loader = new ReceivedPaymentCsvLoader;
        $loader->setFile($file->asSplFileObject());
        $loader->run();

        $report = CsvLoaderReport::create(
            ['label' => "Import des paiements reçus"] + @compact('loader')
        );

        return redirect($report->routes->show);
    }

    public function delete(Enterprise $enterprise, ReceivedPayment $received_payment)
    {
        $this->authorize('delete', $received_payment);

        $deleted = App::make(DeleteReceivedPayment::class)
            ->handle($this->userRepository->connectedUser(), $received_payment);

        return $this->redirectWhen($deleted, route('addworking.billing.received_payment.index', $enterprise));
    }

    public function checkReceivedPaymentAmountAjax(Request $request, Enterprise $enterprise)
    {
        $this->authorize('create', ReceivedPayment::class);

        $request->validate([
            'enterprise_id'    => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
            $outbound_invoices = $this->getOutboundInvoicesById($request->input('outbound_invoices'));

            $outbound_invoices_amount = 0;
            foreach ($outbound_invoices as $outbound_invoice) {
                $outbound_invoices_amount += $outbound_invoice->getAmountAllTaxesIncluded();
            }

            $response = [
                'status' => 200,
                'data' => $outbound_invoices_amount,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    private function getOutboundInvoicesById($outbound_invoices_ids): Collection
    {
        return OutboundInvoice::whereIn('id', $outbound_invoices_ids)->get();
    }

    public function checkCustomerCountryAjax(Request $request, Enterprise $enterprise)
    {
        $request->validate([
            'customer_id'    => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
            $customer_country = Enterprise::whereId($request->input('customer_id'))->first()->getCountry();

            $response = [
                'status' => 200,
                'data' => $customer_country,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
