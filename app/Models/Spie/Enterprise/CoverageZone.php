<?php

namespace App\Models\Spie\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use App\Models\Spie\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CoverageZone extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "spie_enterprise_coverage_zones";

    protected $fillable = [
        'code',
        'label',
    ];

    protected $routePrefix = "spie.enterprise.coverage_zone";

    public function __toString()
    {
        return "({$this->code}) {$this->label}";
    }

    public function enterprises()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'spie_enterprise_enterprises_has_coverage_zones',
            'coverage_zone_id',
            'enterprise_id'
        )->withPivot(['active']);
    }

    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public static function options(array $filter = []): array
    {
        return self::query()
            ->when($filter, function ($query, $filter) {
                $query->whereHas('enterprises', function ($query) use ($filter) {
                    (new Enterprise)->scopeFilter($query, Arr::except($filter, 'coverage_zone'));
                });
            })
            ->get()
            ->sortBy(function ($zone) {
                return (string) $zone;
            })
            ->mapWithKeys(function ($zone) {
                return [$zone->id => (string) $zone];
            })
            ->toArray();
    }
}
