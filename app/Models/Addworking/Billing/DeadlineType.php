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

class DeadlineType extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable, SoftDeletes;

    protected $table = "addworking_billing_deadline_types";

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
        'value' => 'integer'
    ];

    protected $routePrefix = "support.billing.deadline_type";

    protected $viewPrefix  = "support.billing.deadline_type";

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
            throw new UnexpectedValueException("Daedline cannot be negative");
        }

        $this->attributes['value'] = $value;
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }
}
