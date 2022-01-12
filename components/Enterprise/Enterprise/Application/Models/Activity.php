<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\ActivityEntityInterface;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model implements ActivityEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'short_id',
        'code',
        'name',
        'domaine',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'domaine' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function getSector()
    {
        return $this->sector()->first();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }
}
