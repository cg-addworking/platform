<?php

namespace Components\Enterprise\ActivityReport\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityReport extends Model implements ActivityReportInterface, Htmlable
{
    use HasUuid,
        Viewable,
        Routable,
        SoftDeletes;

    protected $table = "addworking_enterprise_activity_reports";

    protected $viewPrefix = "activity_report::activity_report";

    protected $routePrefix = "addworking.enterprise.activity_report";

    protected $routeParameterAliases = [
        'enterprise' => "vendor",
    ];

    protected $fillable = [
        'note',
        'year',
        'month',
        'other_activity',
        'no_activity'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function activityReportCustomers()
    {
        return $this->hasMany(ActivityReportCustomer::class);
    }

    public function activityReportMissions()
    {
        return $this->hasMany(ActivityReportMission::class);
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getVendor(): Enterprise
    {
        return $this->vendor;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setVendor(Enterprise $vendor): void
    {
        $this->vendor()->associate($vendor);
    }

    public function setYear(int $year): void
    {
        $this->year = Carbon::now()->year;
    }

    public function setMonth(int $month): void
    {
        $this->month = $month;
    }

    public function setCreatedBy(User $user): void
    {
        $this->createdBy()->associate($user);
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function setOtherActivity(?string $other_activity): void
    {
        $this->other_activity = $other_activity;
    }

    public function setNoActivity(): void
    {
        $this->no_activity = true;
    }
}
