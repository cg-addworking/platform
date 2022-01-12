<?php

namespace Components\Enterprise\ActivityReport\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportInterface;
use Components\Enterprise\ActivityReport\Domain\Exceptions\ActivityReportCreationFailedException;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportRepositoryInterface;
use DateTime;
use Illuminate\Support\Collection;

class ActivityReportRepository implements ActivityReportRepositoryInterface
{
    public function make($data = []): ActivityReport
    {
        return new ActivityReport($data);
    }

    public function save(ActivityReportInterface $activityReport)
    {
        if (! $activityReport->save()) {
            throw new ActivityReportCreationFailedException($activityReport->getVendor()->id);
        }

        $activityReport->refresh();

        return $activityReport;
    }

    public function getActivityReportAt(Enterprise $vendor, DateTime $date = null): ?ActivityReport
    {
        return $vendor->activityReports
            ->where('year', Carbon::parse($date)->year)
            ->where('month', Carbon::parse($date)->month)
            ->first();
    }

    public function getCustomers(ActivityReport $activityReport): Collection
    {
        $customers = collect();
        foreach ($activityReport->activityReportCustomers as $activityReportCustomer) {
            $customers->push($activityReportCustomer->customer);
        }

        return $customers;
    }
}
