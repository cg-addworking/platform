<?php

namespace App\Models\Spie\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise as AddworkingEnterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity as Activity;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Enterprise extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "spie_enterprise_enterprises";

    protected $fillable = [
        'code',
        'index',
        'active',
        'email',
        'rank',
        'year',
        'gross_income',
        'topology',
        'al',
        'last_coface_enquiry',
        'last_coface_grade',
        'previous_coface_enquiry',
        'previous_coface_grade',
        'nuclear_qualification',
        'addressable_volume_large_order',
        'addressable_volume_average_order',
        'adressable_volume_small_order',
    ];

    protected $casts = [
        'active' => "boolean",
        'rank' => "integer",
        'year' => "integer",
        'gross_income' => "float",
        'al' => "boolean",
        'last_coface_enquiry' => "date",
        'last_coface_grade' => "float",
        'previous_coface_enquiry' => "date",
        'previous_coface_grade' => "float",
        'nuclear_qualification' => "boolean",
        'addressable_volume_large_order' => "boolean",
        'addressable_volume_average_order' => "boolean",
        'adressable_volume_small_order' => "boolean",
    ];

    protected $routePrefix = "spie.enterprise.enterprise";

    public static function fromCode(string $code)
    {
        return self::where('code', $code)->firstOrFail();
    }

    public function enterprise()
    {
        return $this->belongsTo(AddworkingEnterprise::class)->withDefault();
    }

    public function coverageZones()
    {
        return $this->belongsToMany(
            CoverageZone::class,
            'spie_enterprise_enterprises_has_coverage_zones',
            'enterprise_id',
            'coverage_zone_id'
        )->withPivot(['active']);
    }
    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter['code'] ?? null, function ($query, $code) {
            $query->where('code', 'like', "%{$code}%");
        });

        $query->when($filter['name'] ?? null, function ($query, $name) {
            $query->whereHas('enterprise', function ($query) use ($name) {
                $query->ofName($name);
            });
        });

        $query->when($filter['group'] ?? null, function ($query, $group) {
            $query->whereHas('enterprise.parent', function ($query) use ($group) {
                $query->whereId($group);
            });
        });

        $query->when($filter['activity'] ?? null, function ($query, $activity) {
            $query->whereHas('enterprise.activities', function ($query) use ($activity) {
                $query->whereActivity($activity);
            });
        });

        $query->when($filter['town'] ?? null, function ($query, $town) {
            $query->whereHas('enterprise', function ($query) use ($town) {
                $query->whereRegistrationTown($town);
            });
        });

        $query->when($filter['active'] ?? null, function ($query, $active) {
            $table = (new self)->getTable();
            $query->where("{$table}.active", $active == 'true');
        });

        $query->when($filter['coverage_zone'] ?? null, function ($query, $coverage_zone) {
            $query->whereHas('coverageZones', function ($query) use ($coverage_zone) {
                $query->whereIn('id', Arr::wrap($coverage_zone));
            });
        });

        $query->when($filter['department'] ?? null, function ($query, $department) {
            $query->whereHas('coverageZones', function ($query) use ($department) {
                $query->whereHas('department', function ($query) use ($department) {
                    $query->whereIn('id', Arr::wrap($department));
                });
            });
        });

        $query->when($filter['qualification'] ?? null, function ($query, $qualification) {
            $query->whereHas('qualifications', function ($query) use ($qualification) {
                $query->whereId($qualification);
            });
        });

        $query->when($filter['order'] ?? null, function ($query, $order) {
            $query->whereHas('orders', function ($query) use ($order) {
                $boundaries = Order::getBoundariesFromFilter($order);
                $boundaries[1] != INF
                    ? $query->whereBetween('amount', $boundaries)
                    : $query->where('amount', '>=', $boundaries[0]);

                $query->where('year', date('Y'));
            });
        });
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public static function getAvailableGroups(array $filter = []): array
    {
        return AddworkingEnterprise::query()
            ->whereHas('spieEnterprise', function ($query) use ($filter) {
                (new self)->scopeFilter($query, Arr::except($filter, 'group'));
            })
            ->whereHas('parent')
            ->with('parent')
            ->get()
            ->sortBy('parent.name')
            ->mapWithKeys(function ($enterprise) {
                return [$enterprise->parent->id => $enterprise->parent->name];
            })
            ->toArray();
    }

    public static function getAvailableActivities(array $filter = []): array
    {
        return Activity::whereHas('enterprise', function ($query) use ($filter) {
            $query->whereHas('spieEnterprise', function ($query) use ($filter) {
                (new self)->scopeFilter($query, Arr::except($filter, 'activity'));
            });
        })->orderBy('activity')->distinct('activity')->pluck('activity')->toArray();
    }

    public static function getAvailableTowns(array $filter = []): array
    {
        return AddworkingEnterprise::query()
            ->whereHas('spieEnterprise', function ($query) use ($filter) {
                (new self)->scopeFilter($query, Arr::except($filter, 'town'));
            })
            ->orderBy('registration_town')
            ->distinct('registration_town')
            ->pluck('registration_town')
            ->toArray();
    }
}
