<?php

namespace Components\Common\Common\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Domain\Interfaces\Entities\CityEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model implements CityEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "cities";

    protected $fillable = [
        'short_id',
        'name',
        'zip_code',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'name' => 'string',
        'zip_code' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'short_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }
}
