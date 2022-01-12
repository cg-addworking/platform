<?php

namespace Components\Enterprise\ActivityReport\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Components\Enterprise\ActivityReport\Application\Requests\StoreActivityReportRequest;
use Components\Enterprise\ActivityReport\Domain\UseCases\CreateActivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ActivityReportController extends Controller
{
    protected $activityReportRepository;

    public function __construct(ActivityReportRepository $activityReportRepository)
    {
        $this->activityReportRepository = $activityReportRepository;
    }

    public function create(Enterprise $enterprise, Request $request)
    {
        $this->authorize('create', [ActivityReport::class, $enterprise]);

        $activity_report = $this->activityReportRepository->make();
        $activity_report->vendor()->associate($enterprise);

        $month = $request->input('month') ?? Carbon::now()->month;
        $year = $request->input('year') ?? Carbon::now()->year;

        $given_date = $year . $month;

        $date = Carbon::createFromFormat('Ym', $given_date);

        $month_name = strtolower($date->format('F'));

        $start_date = Carbon::createFromFormat('Ym', $given_date)->startOfMonth()->format('d/m/Y');
        $end_date = Carbon::createFromFormat('Ym', $given_date)->endOfMonth()->format('d/m/Y');

        if ($request->user()->cannot('submit', [ActivityReport::class, $enterprise, $date])) {
            return view(
                'activity_report::activity_report.already_submitted',
                compact('activity_report', 'start_date', 'end_date')
            );
        }

        return view(
            'activity_report::activity_report.create',
            compact('activity_report', 'enterprise', 'start_date', 'end_date', 'year', 'month', 'month_name')
        );
    }

    public function store(Enterprise $enterprise, StoreActivityReportRequest $request)
    {
        $this->authorize('create', [ActivityReport::class, $enterprise]);

        $report = DB::transaction(function () use ($request, $enterprise) {
            return App::make(CreateActivityReport::class)->handle(
                $request->user(),
                $enterprise,
                $request->input('activity_report')
            );
        });

        return $this->redirectWhen($report->exists, $enterprise->routes->show);
    }
}
