<?php

namespace Components\Common\Common\Application\Models;

use App\Helpers\HasUuid;
use Components\Common\Common\Domain\Interfaces\Entities\CurrencyEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model implements CurrencyEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "currencies";

    protected $fillable = [
        'short_id',
        'name',
        'acronym',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'name' => 'string',
        'acronym' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getName()
    {
        return $this->name;
    }

    public function getAcronym(): string
    {
        return strtoupper($this->acronym);
    }
}
