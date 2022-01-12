<?php

namespace App\Models\Addworking\Mission;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasNumber;
use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;
use Components\User\User\Domain\Interfaces\UserEntityInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use UnexpectedValueException;

class MissionTracking extends Model implements Htmlable, TrackingEntityInterface
{
    use SoftDeletes, HasUuid, Viewable, Routable, HasNumber, HasAttachments, Commentable;

    protected $table = 'addworking_mission_mission_trackings';

    protected $fillable = [
        'status',
        'description',
        'external_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    protected $routePrefix = "mission.tracking";

    protected $routeParameterAliases = [
        'tracking' => "mission_tracking",
    ];

    public function __toString()
    {
        return (string) substr($this->id ?? 'n/a', 0, 8);
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    /**
     * @todo remove this! as we can have the same info through $tracking->milestone->mission
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class, 'milestone_id');
    }

    public function trackingLines()
    {
        return $this->hasMany(MissionTrackingLine::class, 'tracking_id');
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getDescriptionHtmlAttribute()
    {
        return new HtmlString(strip_tags(nl2br($this->description), '<br>'));
    }

    public function setStatusAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeStartsAt($query, $date)
    {
        return $query->whereHas('milestone', function ($query) use ($date) {
            return $query->where('starts_at', 'like', "%{$date}%");
        });
    }

    public function scopeEndsAt($query, $date)
    {
        return $query->whereHas('milestone', function ($query) use ($date) {
            return $query->where('ends_at', 'like', "%{$date}%");
        });
    }

    public function scopeMonth($query, $month)
    {
        return $query->whereHas('milestone', function ($query) use ($month) {
            return $query->whereMonth('ends_at', $month);
        });
    }

    public function scopeCustomerName($query, $enterprise)
    {
        return $query->whereHas('mission', function ($query) use ($enterprise) {
            return $query->whereHas('customer', function ($query) use ($enterprise) {
                $query->where('name', 'like', "%".strtoupper($enterprise)."%");
            });
        });
    }

    public function scopeVendorName($query, $enterprise)
    {
        return $query->whereHas('mission', function ($query) use ($enterprise) {
            return $query->whereHas('vendor', function ($query) use ($enterprise) {
                $query->where('name', 'like', "%".strtoupper($enterprise)."%");
            });
        });
    }

    public function scopeMissionLabel($query, $mission)
    {
        return $query->whereHas('mission', function ($query) use ($mission) {
            $query->where('label', 'like', "%".$mission."%");
        });
    }

    public function scopeMissionNumber($query, $number)
    {
        return $query->whereHas('mission', function ($query) use ($number) {
            $query->where('number', $number);
        });
    }

    public function scopeOfVendor($query, Enterprise $enterprise)
    {
        return $query->whereHas('mission', function ($query) use ($enterprise) {
            return $query->ofVendor($enterprise);
        });
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->whereHas('mission', function ($query) use ($enterprise) {
            return $query->ofCustomer($enterprise);
        });
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('mission', function ($query) use ($enterprise) {
            return $query->ofEnterprise($enterprise);
        });
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isValidated()
    {
        return $this->status == self::STATUS_VALIDATED;
    }

    public function isRefused()
    {
        return $this->status == self::STATUS_REFUSED;
    }

    public function isSearchForAgreement()
    {
        return $this->status == self::STATUS_SEARCH_FOR_AGREEMENT;
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_VALIDATED,
            self::STATUS_REFUSED,
            self::STATUS_SEARCH_FOR_AGREEMENT,
        ];
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this tracking doesn't exists");
        }

        return $this->id;
    }

    public function getMission(): MissionEntityInterface
    {
        if (! $this->mission->exists) {
            throw new \RuntimeException("no mission is attached to this instance");
        }

        return $this->mission;
    }

    public function setMission(MissionEntityInterface $mission): self
    {
        $this->mission()->associate($mission->getId());

        return $this;
    }

    public function getMilestone(): MilestoneEntityInterface
    {
        if (! $this->milestone->exists) {
            throw new \RuntimeException("no milestone is attached to this instance");
        }

        return $this->milestone;
    }

    public function setMilestone(MilestoneEntityInterface $milestone): self
    {
        $this->milestone()->associate($milestone->getId());

        return $this;
    }

    public function getUser(): ?UserEntityInterface
    {
        if (! $this->user->exists) {
            return null;
        }

        return $this->user;
    }

    public function setUser(?UserEntityInterface $user): self
    {
        is_null($user)
            ? $this->user()->dissociate()
            : $this->user()->associate($user->getId());

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExternalId():?string
    {
        return $this->external_id;
    }

    public function setExternalId(?string $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }
}
