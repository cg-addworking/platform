<?php

namespace App\Models\Addworking\Billing;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @todo this should be a normal CRUD
 */
class VendorsAvailableBillingDeadlines extends Model implements Htmlable
{
    use SoftDeletes, Viewable, Routable, HasUuid;

    protected $table = "addworking_billing_vendors_available_billing_deadlines";

    protected $fillable = [
        'customer_id',
        'vendor_id',
        'upon_receipt',
        '30_days',
        '40_days',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $routePrefix = "";

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_id');
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_id');
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeOfVendor($query, Enterprise $vendor)
    {
        return $query->whereHas('vendor', function ($query) use ($vendor) {
            return $query->where('id', $vendor->id);
        });
    }

    public function scopeOfCustomer($query, Enterprise $customer)
    {
        return $query->whereHas('customer', function ($query) use ($customer) {
            return $query->where('id', $customer->id);
        });
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public function delinearize(bool $trans = false): array
    {
        $array = [];

        foreach (InboundInvoice::getAllAvailableDeadlines(true) as $key => $value) {
            if ($this[$key]) {
                $array[$key] = $value;
            }
        }

        return $trans ? $array : array_keys($array);
    }
}
