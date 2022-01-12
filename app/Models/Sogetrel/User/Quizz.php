<?php

namespace App\Models\Sogetrel\User;

use App\Helpers\HasUuid;

use App\Models\Sogetrel\User\Passwork;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @todo rename to PassworkQuizz
 */
class Quizz extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "sogetrel_user_passwork_quizzes";

    const STATUS_PENDING  = "pending";
    const STATUS_DONE     = "done";

    protected $fillable = [
        "status",
        "job",
        "score",
        "url",
        "proposed_at",
        "completed_at",
    ];

    protected $dates = [
        "proposed_at",
        "completed_at",
    ];

    protected $casts = [
        'score' => "float",
    ];

    protected $routePrefix = "sogetrel.passwork.quizz";

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function passwork()
    {
        return $this->belongsTo(Passwork::class);
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setStatusAttribute($value)
    {
        if (! in_array($value, self::getAvailableStatuses())) {
            throw new InvalidArgumentException("invalid status");
        }

        $this->attributes['status'] = $value;
    }

    public function setScoreAttribute($value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("score cannot be negative");
        }

        $this->attributes['score'] = floatval($value);
    }

    public function setProposedAtAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['proposed_at'] = $this->fromDateTime($value);
    }

    public function setCompletedAtAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['completed_at'] = $this->fromDateTime($value);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public static function getAvailableStatuses(): array
    {
        return [self::STATUS_PENDING, self::STATUS_DONE];
    }
}
