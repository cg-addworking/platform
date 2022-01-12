<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Common\CsvLoaderReport\StoreCsvLoaderReportRequest;
use App\Http\Requests\Addworking\Common\CsvLoaderReport\UpdateCsvLoaderReportRequest;
use App\Repositories\BaseRepository;
use App\Models\Addworking\Common\CsvLoaderReport;

class CsvLoaderReportRepository extends BaseRepository
{
    protected $model = CsvLoaderReport::class;

    public function createFromRequet(StoreCsvLoaderReportRequest $request): CsvLoaderReport
    {
        return $this->create($request->input('csv_loader_report'));
    }

    public function updateFromRequest(
        UpdateCsvLoaderReportRequest $request,
        CsvLoaderReport $csv_loader_report
    ): CsvLoaderReport {
        return $this->update($csv_loader_report, $request->input('csv_loader_report'));
    }
}
