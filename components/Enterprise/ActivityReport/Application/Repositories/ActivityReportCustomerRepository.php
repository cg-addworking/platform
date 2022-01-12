<?php

namespace Components\Enterprise\ActivityReport\Application\Repositories;

use App\Models\Addworking\Enterprise\EnterpriseCollection;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReportCustomer;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportCustomerInterface;
use Components\Enterprise\ActivityReport\Domain\Exceptions\ActivityReportCustomerCreationFailedException;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportCustomerRepositoryInterface;

class ActivityReportCustomerRepository implements ActivityReportCustomerRepositoryInterface
{
    public function make($data = []): ActivityReportCustomer
    {
        return new ActivityReportCustomer($data);
    }

    public function save(ActivityReportCustomerInterface $activityReportCustomer): bool
    {
        $saved = $activityReportCustomer->save();

        if (!$saved) {
            throw new ActivityReportCustomerCreationFailedException($activityReportCustomer->getCustomer()->id);
        }

        return $saved;
    }

    public function associateCustomers(ActivityReport $activityReport, EnterpriseCollection $customers): void
    {
        foreach ($customers as $customer) {
            $activityReportCustomer = $this->make();
            $activityReportCustomer->setActivityReport($activityReport);
            $activityReportCustomer->setCustomer($customer);
            $this->save($activityReportCustomer);
        }
    }
}
