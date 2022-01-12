<?php

namespace App\Models\Spie\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Spie\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Qualification extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "spie_enterprise_qualifications";

    protected $fillable = [
        'code',
        'name',
        'display_name',
        'follow_up',
        'active',
        'valid_until',
        'revived_at',
        'site',
    ];

    protected $casts = [
        'follow_up' => "boolean",
        'active' => "boolean",
        'valid_until' => "date",
        'revived_at' => "date",
    ];

    protected $routePrefix = "spie.enterprise.enterprise.qualification";

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public static function options(array $filter = []): array
    {
        return self::query()
            ->when($filter, function ($query, $filter) {
                $query->whereHas('enterprise', function ($query) use ($filter) {
                    (new Enterprise)->scopeFilter($query, Arr::except($filter, 'coverage_zone'));
                });
            })
            ->orderBy('display_name')
            ->pluck('display_name', 'id')
            ->toArray();
    }
}
