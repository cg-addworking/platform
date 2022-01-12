<?php

namespace Components\Enterprise\InvoiceParameter\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Application\Repositories\CustomerBillingDeadlineRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\IbanRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Application\Requests\StoreInvoiceParameterRequest;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\CreateInvoiceParameter;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\EditInvoiceParameter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class InvoiceParameterController extends Controller
{
    protected $invoiceParameterRepository;
    protected $ibanRepository;
    protected $userRepository;
    protected $enterpriseRepository;

    public function __construct(
        InvoiceParameterRepository $invoiceParameterRepository,
        IbanRepository $ibanRepository,
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository
    ) {
        $this->invoiceParameterRepository = $invoiceParameterRepository;
        $this->ibanRepository = $ibanRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
    }

    public function index(Enterprise $enterprise)
    {
        $this->authorize('index', InvoiceParameter::class);

        $items = $this->invoiceParameterRepository->list($enterprise);

        return view('invoice_parameter::index', compact('enterprise', 'items'));
    }

    public function show(Enterprise $enterprise, InvoiceParameter $invoiceParameter)
    {
        $this->authorize('show', $invoiceParameter);

        $deadlines = [];

        $deadlines_by_default = CustomerBillingDeadline::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->get();

        foreach ($deadlines_by_default as $deadline) {
            $deadlines[] = $deadline->getDeadline()->display_name;
        }

        return view('invoice_parameter::show', compact('enterprise', 'invoiceParameter', 'deadlines'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [InvoiceParameter::class, $enterprise]);

        $addworking = Enterprise::where('name', "ADDWORKING")->first();
        $addworking_ibans = $this->ibanRepository->getAllByEnterprise($addworking)->pluck('formatted_label', 'id');

        $invoice_parameter = $this->invoiceParameterRepository->make();

        $deadlines = DeadlineType::all()->pluck('display_name', 'id');

        return view(
            'invoice_parameter::create',
            compact(
                'enterprise',
                'addworking_ibans',
                'invoice_parameter',
                'deadlines',
            )
        );
    }

    public function store(StoreInvoiceParameterRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [InvoiceParameter::class, $enterprise]);

        $auth_user = $this->userRepository->connectedUser();
        $invoice_parameter = App::make(CreateInvoiceParameter::class)->handle(
            $auth_user,
            $request->input(),
            $enterprise
        );

        return $this->redirectWhen(
            $invoice_parameter->exists,
            route('addworking.enterprise.parameter.show', [$enterprise, $invoice_parameter])
        );
    }

    /**
     * @param Enterprise $enterprise
     * @param InvoiceParameter $invoice_parameter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Enterprise $enterprise, InvoiceParameter $invoice_parameter)
    {
        $this->authorize('edit', $invoice_parameter);

        $selected_deadlines = App::make(CustomerBillingDeadlineRepository::class)->getDefaultDeadLinesOf($enterprise);

        $addworking = Enterprise::where('name', "ADDWORKING")->first();
        $addworking_ibans = $this->ibanRepository->getAllByEnterprise($addworking)->pluck('formatted_label', 'id');

        $deadlines = DeadlineType::all()->pluck('display_name', 'id');

        return view(
            'invoice_parameter::edit',
            compact(
                'enterprise',
                'addworking_ibans',
                'invoice_parameter',
                'deadlines',
                'selected_deadlines'
            )
        );
    }

    /**
     * @param Enterprise $enterprise
     * @param InvoiceParameter $invoice_parameter
     * @param StoreInvoiceParameterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        Enterprise $enterprise,
        InvoiceParameter $invoice_parameter,
        StoreInvoiceParameterRequest $request
    ) {
        $this->authorize('edit', $invoice_parameter);

        $auth_user = $this->userRepository->connectedUser();

        $invoice_parameter = App::make(EditInvoiceParameter::class)->handle(
            $auth_user,
            $request->input(),
            $enterprise,
            $invoice_parameter
        );

        return $this->redirectWhen(
            $invoice_parameter->exists,
            route('addworking.enterprise.parameter.show', [$enterprise, $invoice_parameter])
        );
    }
}
