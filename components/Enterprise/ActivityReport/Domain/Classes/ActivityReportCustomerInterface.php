<?php

namespace Components\Enterprise\ActivityReport\Domain\Classes;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;

interface ActivityReportCustomerInterface
{
    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getCustomer(): Enterprise;

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------
    public function setCustomer(Enterprise $customer): void;
    public function setActivityReport(ActivityReport $activityReport): void;
}
