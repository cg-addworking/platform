<?php

namespace Components\Enterprise\InvoiceParameter\Application\Models;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Domain\Classes\CustomerBillingDeadlineInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HasUuid;

class CustomerBillingDeadline extends Model implements CustomerBillingDeadlineInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "customer_billing_deadlines";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function deadline()
    {
        return $this->belongsTo(DeadlineType::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setEnterprise($enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setDeadline($deadline): void
    {
        $this->deadline()->associate($deadline);
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getDeadline(): DeadlineType
    {
        return $this->deadline()->first();
    }
}
