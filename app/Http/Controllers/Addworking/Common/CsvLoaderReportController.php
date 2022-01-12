<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Models\Addworking\Common\CsvLoaderReport;
use App\Http\Requests\Addworking\Common\CsvLoaderReport\StoreCsvLoaderReportRequest;
use App\Http\Requests\Addworking\Common\CsvLoaderReport\UpdateCsvLoaderReportRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Addworking\Common\CsvLoaderReportRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class CsvLoaderReportController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(CsvLoaderReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CsvLoaderReport::class);

        $items = $this->getPaginatorFromRequest($request);

        return view('addworking.common.csv_loader_report.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', CsvLoaderReport::class);

        $csv_loader_report = $this->repository->make();

        return view('addworking.common.csv_loader_report.create', @compact('csv_loader_report'));
    }

    public function store(StoreCsvLoaderReportRequest $request)
    {
        $this->authorize('create', CsvLoaderReport::class);

        $csv_loader_report = $this->repository->createFromRequest($request);

        return redirect_when($csv_loader_report->exists, $csv_loader_report->routes->show);
    }

    public function show(CsvLoaderReport $csv_loader_report)
    {
        $this->authorize('view', $csv_loader_report);

        return view('addworking.common.csv_loader_report.show', @compact('csv_loader_report'));
    }

    public function edit(CsvLoaderReport $csv_loader_report)
    {
        $this->authorize('update', $csv_loader_report);

        return view('addworking.common.csv_loader_report.edit', @compact('csv_loader_report'));
    }

    public function update(UpdateCsvLoaderReportRequest $request, CsvLoaderReport $csv_loader_report)
    {
        $this->authorize('update', $csv_loader_report);

        $csv_loader_report = $this->repository->updateFromRequest($request, $csv_loader_report);

        return redirect_when($csv_loader_report->exists, $csv_loader_report->routes->show);
    }

    public function destroy(CsvLoaderReport $csv_loader_report)
    {
        $this->authorize('delete', $csv_loader_report);

        $deleted = $this->repository->delete($csv_loader_report);

        return redirect_when($deleted, $csv_loader_report->routes->index);
    }

    public function download(CsvLoaderReport $csv_loader_report)
    {
        $this->authorize('download', $csv_loader_report);

        return response()->download($csv_loader_report->error_csv, 'errors.csv')->deleteFileAfterSend(true);
    }
}
