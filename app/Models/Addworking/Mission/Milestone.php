<?php

namespace App\Models\Addworking\Mission;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use DateTime;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use LogicException;
use UnexpectedValueException;

class Milestone extends Model implements Htmlable, MilestoneEntityInterface
{
    use SoftDeletes, HasUuid, Viewable, Routable;

    protected $table = 'addworking_mission_milestones';

    protected $fillable = [
        'starts_at',
        'ends_at',
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }

    public function missionTrackings()
    {
        return $this->hasMany(MissionTracking::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeBetween($query, DateTime $from, DateTime $to)
    {
        return $query->where('starts_at', '>=', $from)->where('ends_at', '<=', $to);
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getLabelAttribute()
    {
        return sprintf('%s - %s', $this->starts_at->format('d/m/Y'), $this->ends_at->format('d/m/Y'));
    }

    public static function getDateRanges(DateTime $from, DateTime $to, string $granularity): array
    {
        if (! in_array($granularity, self::getAvailableMilestoneTypes())) {
            throw new UnexpectedValueException("Invalid granularity: {$granularity}");
        }

        if (! $from instanceof Carbon) {
            $from = Carbon::instance($from);
        }

        if (! $to instanceof Carbon) {
            $to = Carbon::instance($to);
        }

        if ($to->lessThan($from)) {
            throw new LogicException("\$from parameter cannot be greater than \$to");
        }

        if ($granularity == self::MILESTONE_END_OF_MISSION) {
            return [[$from, $to]];
        }

        $period = [
            self::MILESTONE_WEEKLY    => "week",
            self::MILESTONE_MONTHLY   => "month",
            self::MILESTONE_QUARTERLY => "quarter",
            self::MILESTONE_ANNUAL    => "year",
        ][$granularity];

        return Collection::wrap(
            CarbonPeriod::create($from->startOf($period), "1 {$period}", $to->endOf($period))->toArray()
        )->map(function ($start) use ($period) {
            return [$start, (clone $start)->endOf($period)];
        })->toArray();
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this milestone doesn't exists");
        }

        return $this->id;
    }

    public function belongsToMission(MissionEntityInterface $mission): bool
    {
        return $this->mission->id == $mission->getId();
    }

    public static function getAvailableMilestoneTypes(): array
    {
        return [
            self::MILESTONE_WEEKLY,
            self::MILESTONE_MONTHLY,
            self::MILESTONE_QUARTERLY,
            self::MILESTONE_ANNUAL,
            self::MILESTONE_END_OF_MISSION,
        ];
    }
}
