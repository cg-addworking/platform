<?php

namespace Components\Enterprise\WorkField\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model implements SectorEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_sectors";

    protected $fillable = [
        'number',
        'name',
        'display_name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function enterprises()
    {
        return $this->belongdToMany(
            Enterprise::class,
            'addworking_enterprise_enterprises_has_sectors',
            'enterprise_id',
            'sector_id'
        )->withTimestamps();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------


    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
