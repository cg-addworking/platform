<?php

namespace App\Models\Soprema\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Covid19FormAnswer extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = "soprema_enterprise_covid19_form_answers";

    protected $fillable = [
        'vendor_name',
        'vendor_siret',
        'pursuit',
        'message',
    ];

    protected $routePrefix = "soprema.enterprise.covid19_form_answer";

    public function __toString()
    {
        return substr($this->id, 0, 8);
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->where(function ($query) use ($enterprise) {
            return $query
                ->where('customer_id', $enterprise->id)
                ->orWhereHas('vendor', function ($query) use ($enterprise) {
                    return $query->whereHas('customers', function ($query) use ($enterprise) {
                        return $query->where('id', $enterprise->id);
                    });
                });
        });
    }
}
