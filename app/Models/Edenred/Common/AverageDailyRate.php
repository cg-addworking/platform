<?php

namespace App\Models\Edenred\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;

use App\Models\Edenred\Common\Code;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AverageDailyRate extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "edenred_common_average_daily_rates";

    protected $fillable = [
        'rate',
    ];

    protected $casts = [
        'rate' => "float",
    ];

    protected $routePrefix = "edenred.common.code.average_daily_rate";

    public function __toString()
    {
        return number_format($this->rate, 2);
    }

    public function code()
    {
        return $this->belongsTo(Code::class)->withDefault();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function setRateAttribute($value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("rate cannot be negative");
        }

        $this->attributes['rate'] = $value;
    }

    public function scopeOfCode($query, Code $code)
    {
        return $query->where('code_id', $code->id);
    }

    public function scopeOfVendor($query, Enterprise $vendor)
    {
        return $query->where('vendor_id', $vendor->id);
    }

    public function getAvailableVendors(): array
    {
        return Enterprise::fromName('EDENRED')->vendors()->pluck('name', 'id')->toArray();
    }
}
