<?php

namespace App\Models\Spie\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Spie\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "spie_enterprise_orders";

    protected $fillable = [
        'short_label',
        'year',
        'subsidiary_company_label',
        'direction_label',
        'amount',
    ];

    protected $casts = [
        'year' => "integer",
        'amount' => "float",
    ];

    protected $routePrefix = "spie.enterprise.enterprise.order";

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public static function getBoundariesFromFilter($filter): array
    {
        switch ($filter) {
            case 'moins de 1000€':
                return [0, 999];
            case 'entre 1000€ et 10K€':
                return [1000, 1e4-1];
            case 'entre 10K€ et 50K€':
                return [1e4, 5e4-1];
            case 'entre 50K€ et 100K€':
                return [5e4, 1e5-1];
            case 'entre 100K€ et 200K€':
                return [1e5, 2e5-1];
            case 'entre 200K€ et 500K€':
                return [2e5, 5e5-1];
            case 'plus de 500K€':
                return [5e5, INF];
        }

        return [INF, INF];
    }
}
