<?php

namespace App\Models\Addworking\Billing;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use UnexpectedValueException;

class VatRate extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable, SoftDeletes;

    protected $table = "addworking_billing_vat_rates";

    protected $fillable = [
        'display_name',
        'name',
        'value',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    protected $routePrefix = "support.billing.vat_rate";

    protected $viewPrefix  = "support.billing.vat_rate";

    public function __toString()
    {
        return (string) $this->display_name;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_slug($value, '_');
    }

    public function setVatRateAttribute($value)
    {
        if ($value < 0) {
            throw new UnexpectedValueException("VAT rate cannot be negative");
        }

        if ($value > 1) {
            throw new UnexpectedValueException("VAT rate cannot exceed 100%");
        }

        $this->attributes['value'] = $value;
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }
}
