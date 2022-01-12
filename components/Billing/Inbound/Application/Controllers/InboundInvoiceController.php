<?php

namespace Components\Billing\Inbound\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\Inbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Inbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Inbound\Application\Repositories\UserRepository;
use Components\Billing\Inbound\Domain\UseCases\ListInboundInvoicesAsCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use App\Jobs\Addworking\Billing\SendInboundInvoiceCsvExportJob;
use Illuminate\Support\Collection;

class InboundInvoiceController extends Controller
{
    protected $userRepository;
    protected $inboundInvoiceRepository;

    public function __construct(
        UserRepository $userRepository,
        InboundInvoiceRepository $inboundInvoiceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->inboundInvoiceRepository = $inboundInvoiceRepository;
    }

    public function indexCustomer(Request $request)
    {
        $this->authorize('indexCustomer', InboundInvoice::class);

        $items = App::make(ListInboundInvoicesAsCustomer::class)
            ->handle(
                $this->userRepository->connectedUser(),
                $request->input('filter'),
                $request->input('search'),
                $request->input('per-page')
            );
        $amounts = $this->inboundInvoiceRepository
            ->filterAndSearch(
                $this->userRepository->connectedUser(),
                $request->input('filter') ?? ["status" => "paid"],
                $request->input('search')
            )->select(['amount_before_taxes', 'amount_of_taxes', 'amount_all_taxes_included'])->get();

        $total_amount_before_taxes = $amounts->sum('amount_before_taxes');
        $total_amount_of_taxes = $amounts->sum('amount_of_taxes');
        $total_amount_all_taxes_included = $amounts->sum('amount_all_taxes_included');
        $number_total_of_invoices = $amounts->count();

        $vendors = App::make(EnterpriseRepository::class)
                ->getVendorsOfUserEnterprises($this->userRepository->connectedUser())->pluck('name', 'id');
        return view('inbound::indexCustomer', compact(
            'items',
            'total_amount_before_taxes',
            'total_amount_of_taxes',
            'total_amount_all_taxes_included',
            'number_total_of_invoices',
            'vendors'
        ));
    }

    public function export(Request $request)
    {
        $this->authorize('export', InboundInvoice::class);

        $inbound_invoices = $this->inboundInvoiceRepository
            ->filterAndSearch(
                $this->userRepository->connectedUser(),
                $request->input('filter'),
                $request->input('search')
            )->get();

        $export = App::make(ExportRepository::class)->create(
            $request->user(),
            "export_inbound_invoices_".Carbon::now()->format('Ymd_His'),
            $request->input('filter') ?? []
        );

        SendInboundInvoiceCsvExportJob::dispatch(
            $request->user(),
            $inbound_invoices,
            $export,
            App::make(ExportRepository::class)
        );

        return redirect()->back()->with(success_status(
            __('addworking.billing.inbound_invoice.export.success')
        ));
    }
}
