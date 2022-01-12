<?php

namespace App\Models\Everial\Mission;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model implements Htmlable
{
    use SoftDeletes,
        HasUuid,
        Viewable,
        Routable;

    protected $table = 'everial_mission_price_lists';

    protected $fillable = [
        'amount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $attributes = [
        'amount'      => 0,
    ];

    protected $routePrefix = 'everial.mission.referential.price';

    protected $routeParameterAliases = [
        'enterprise' => "vendor",
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_id')->withDefault();
    }

    public function referential()
    {
        return $this->belongsTo(Referential::class, 'referential_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public static function getPriceFromReferential(Referential $referential, Enterprise $vendor)
    {
        return self::query()
            ->whereHas('referential', function ($query) use ($referential) {
                $query->where('id', $referential->id);
            })->whereHas('vendor', function ($query) use ($vendor) {
                $query->where('id', $vendor->id);
            })->firstOrNew([])->amount ?? 'n/a';
    }
}
