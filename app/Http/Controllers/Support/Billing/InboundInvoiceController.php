<?php

namespace App\Http\Controllers\Support\Billing;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Repositories\Addworking\Billing\InboundInvoiceRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\Addworking\Billing\SendInboundInvoiceCsvExportJob;
use Illuminate\Support\Facades\App;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;

class InboundInvoiceController extends Controller
{
    use HandlesIndex;

    protected $repository;
    protected $exportRepository;

    public function __construct(InboundInvoiceRepository $repository, ExportRepository $exportRepository)
    {
        $this->repository = $repository;
        $this->exportRepository = $exportRepository;
    }

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request, null);

        return view('support.billing.inbound_invoice.index', @compact('items'));
    }

    public function export(Request $request)
    {
        $this->authorize('export', InboundInvoice::class);

        $inbound_invoices = $this->repository->list($request->input('search'), $request->input('filter'))->get();

        $export = $this->exportRepository->create(
            $request->user(),
            "export_inbound_invoices_".Carbon::now()->format('Ymd_His'),
            $request->input('filter') ?? []
        );

        SendInboundInvoiceCsvExportJob::dispatch(
            $request->user(),
            $inbound_invoices,
            $export,
            $this->exportRepository
        );

        return redirect()->back()->with(success_status(
            __('addworking.billing.inbound_invoice.export.success')
        ));
    }
}
