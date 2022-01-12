<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class Passwork extends Model implements Htmlable
{
    use HasUuid,
        HasAttachments,
        Viewable,
        Routable;

    protected $table = "addworking_common_passworks";

    protected $routePrefix = "addworking.common.enterprise.passwork";

    protected $routeParameterAliases = [
        'enterprise' => "passworkable",
    ];

    public function __toString()
    {
        return substr($this->id, 0, 8);
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function passworkable()
    {
        return $this->morphTo();
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'addworking_common_passworks_has_skills',
            'passwork_id',
            'skill_id'
        )->withPivot(
            'level'
        )->withTimestamps();
    }

    public function getVendorAttribute(): Enterprise
    {
        if (($vendor = $this->passworkable) instanceof Enterprise) {
            return $vendor;
        }

        return new Enterprise;
    }

    public function getUserAttribute(): User
    {
        if (($user = $this->passworkable) instanceof User) {
            return $user;
        }

        return new User;
    }

    public function getAvailableCustomers(): array
    {
        $vendor = $this->passworkable instanceof User
            ? $this->passworkable->enterprise
            : $this->passworkable;

        if (! $vendor instanceof Enterprise) {
            throw new RuntimeException("Invalid passworkable");
        }

        return $vendor->customers()->orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function hasSkill(Skill $skill): bool
    {
        return $this->skills->contains($skill);
    }

    public function getLevelFor(Skill $skill)
    {
        $skill = $this->skills()->find($skill->id);

        if (is_null($skill)) {
            return null;
        }

        return $skill->pivot->level;
    }

    public function scopeOfVendor($query, Model $vendor)
    {
        // $vendor can be either an Enterprise or User instance,
        // hence the passworkable polymorph.
        return $query->where('passworkable_id', $vendor->id);
    }

    public function scopeOfCustomer($query, Enterprise $customer)
    {
        return $query->where('customer_id', $customer->id);
    }
}
