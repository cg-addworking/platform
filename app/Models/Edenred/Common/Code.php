<?php

namespace App\Models\Edenred\Common;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Code extends Model implements Htmlable, Searchable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "edenred_common_codes";

    protected $fillable = [
        'level',
        'code',
    ];

    protected $routePrefix = "edenred.common.code";

    protected $searchable = [
        'code'
    ];

    public function __toString()
    {
        return (string) "{$this->code} {$this->level}";
    }

    public function job()
    {
        return $this->skill->job();
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class)->withDefault();
    }

    public function averageDailyRates()
    {
        return $this->hasMany(AverageDailyRate::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterJob($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterSkill($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeFilterJob($query, $job)
    {
        return $query->whereHas('skill', function ($query) use ($job) {
            $query->whereHas('job', function ($query) use ($job) {
                $query->where(DB::raw('LOWER(display_name)'), 'LIKE', "%". strtolower($job)."%");
            });
        });
    }

    public function scopeFilterSkill($query, $skill)
    {
        return $query->whereHas('skill', function ($query) use ($skill) {
            $query->where(DB::raw('LOWER(display_name)'), 'LIKE', "%". strtolower($skill)."%");
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getFullLabelAttribute()
    {
        return "{$this->code} {$this->level}, {$this->skill->job} - {$this->skill} - Niveau {$this->level}";
    }

    public function getLabelAttribute()
    {
        return "{$this->code} {$this->level}";
    }

    public static function getAvailableSkills(): array
    {
        return Skill::query()
            ->whereHas('job', function ($query) {
                $query->where('enterprise_id', Enterprise::fromName('EDENRED')->id);
            })->get()->mapWithKeys(function ($skill) {
                return [$skill->id => "{$skill->job} - {$skill}"];
            })->toArray();
    }
}
