<?php

namespace Components\Common\Common\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model implements CountryEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "countries";

    protected $fillable = [
        'short_id',
        'code',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function getCode()
    {
        return strtoupper($this->code);
    }
}
