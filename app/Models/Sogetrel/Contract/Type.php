<?php

namespace App\Models\Sogetrel\Contract;

use App\Helpers\HasUuid;
use App\Models\Sogetrel\User\Passwork;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Type extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = 'sogetrel_contract_types';

    protected $fillable = [
        'name',
        'display_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function passworks()
    {
        return $this->belongsToMany(
            Passwork::class,
            'sogetrel_user_passworks_has_contract_types',
            'type_id',
            'passwork_id'
        )->withTimestamps();
    }
}
