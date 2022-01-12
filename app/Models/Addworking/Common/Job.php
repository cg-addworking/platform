<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Job extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "addworking_common_jobs";

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected $routePrefix = "addworking.common.enterprise.job";

    public function __toString()
    {
        return (string) $this->display_name;
    }

    public function parent()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function getAvailableParents(): array
    {
        return self::where('enterprise_id', $this->enterprise->id)
            ->orderBy('display_name')
            ->pluck('display_name', 'id')
            ->except($this->id)
            ->toArray();
    }

    public function getAvailableEnterprises(): array
    {
        return Enterprise::where('is_customer', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function scopeOfEnterprise($builder, Enterprise $enterprise)
    {
        return $builder->where('enterprise_id', $enterprise->id);
    }

    public function scopeOfEnterprises($builder, Collection $enterprises)
    {
        return $builder->whereIn('enterprise_id', $enterprises->pluck('id'));
    }
}
