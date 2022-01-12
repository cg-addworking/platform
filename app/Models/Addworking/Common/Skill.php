<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Models\Addworking\Mission\Offer;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "addworking_common_skills";

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected $routePrefix = "addworking.common.enterprise.job.skill";

    public function __toString()
    {
        return (string) $this->display_name;
    }

    public function job()
    {
        return $this->belongsTo(Job::class)->withDefault();
    }

    public function passworks()
    {
        return $this->belongsToMany(
            Passwork::class,
            'addworking_common_passworks_has_skills',
            'skill_id',
            'passwork_id'
        )->withPivot(
            'level'
        )->withTimestamps();
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'addworking_mission_offers_has_skills')->withTimestamps();
    }

    public function scopeOfJob($query, Job $job)
    {
        return $query->where('job_id', $job->id);
    }
}
