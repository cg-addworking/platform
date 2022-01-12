<?php

namespace Components\Enterprise\ActivityReport\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportCustomerInterface;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportInterface;
use Illuminate\Database\Eloquent\Model;

class ActivityReportCustomer extends Model implements ActivityReportCustomerInterface
{
    use HasUuid;

    protected $table = "addworking_enterprise_activity_report_has_customers";

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function activityReport()
    {
        return $this->belongsTo(ActivityReport::class, 'activity_report_id')->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getCustomer(): Enterprise
    {
        return $this->customer;
    }


    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setCustomer(Enterprise $customer): void
    {
        $this->customer()->associate($customer);
    }

    public function setActivityReport(ActivityReport $activityReport): void
    {
        $this->activityReport()->associate($activityReport);
    }
}
