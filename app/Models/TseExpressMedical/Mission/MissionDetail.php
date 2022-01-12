<?php

namespace App\Models\TseExpressMedical\Mission;

use App\Helpers\HasUuid;
use App\Models\Addworking\Mission\Mission;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionDetail extends Model implements Htmlable
{
    use SoftDeletes,
        HasUuid,
        Viewable,
        Routable;

    protected $table = 'tse_express_medical_mission_mission_details';

    protected $fillable = [
        'gasoil_tax',
        'equipment_rental',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
