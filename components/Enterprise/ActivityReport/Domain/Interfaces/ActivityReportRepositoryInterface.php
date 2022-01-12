<?php

namespace Components\Enterprise\ActivityReport\Domain\Interfaces;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportInterface;
use DateTime;

interface ActivityReportRepositoryInterface extends RepositoryInterface
{
    public function save(ActivityReportInterface $activityReport);
    public function getActivityReportAt(Enterprise $vendor, DateTime $date = null): ?ActivityReport;
}
