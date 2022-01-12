<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class EnterpriseActivity extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = 'addworking_enterprise_activities';

    protected $fillable = [
        'activity',
        'field',
        'employees_count',
    ];

    protected $attributes = [
        'field' => "Autre",
        'employees_count' => 0,
    ];

    protected $casts = [
        'employees_count' => "integer",
    ];

    protected $routePrefix = "enterprise.activity";

    protected $routeParameterAliases = [
        'activity' => 'enterprise_activity',
    ];

    public function __toString()
    {
        return (string) $this->activity;
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'addworking_enterprise_activities_has_departments',
            'activity_id'
        );
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setActivityAttribute($value)
    {
        $this->attributes['activity'] = ucfirst($value);
    }

    public static function getAvailableFields(): array
    {
        return [
            "Autre", "Administration", "Agriculture",
            "Agroalimentaire", "Armée", "Art", "Associations",
            "Assurances", "Bâtiment", "Commerce", "Conseil",
            "Energie", "Enseignement", "Environnement",
            "Equipements", "Finance", "Formation", "Hôtellerie",
            "Immobilier", "Industrie", "Internet", "Loisirs",
            "Média", "Médical", "Mode", "Négoce", "NTIC",
            "P. Libérale", "Recherche", "Recrutement",
            "Sécurité", "Services", "Transport",
        ];
    }
}
