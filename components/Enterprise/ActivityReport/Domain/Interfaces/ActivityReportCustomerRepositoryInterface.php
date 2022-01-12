<?php

namespace Components\Enterprise\ActivityReport\Domain\Interfaces;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportCustomerInterface;

interface ActivityReportCustomerRepositoryInterface extends RepositoryInterface
{
    public function save(ActivityReportCustomerInterface $activityReportCustomer): bool;
    public function associateCustomers(ActivityReport $activityReport, EnterpriseCollection $customers): void;
}
