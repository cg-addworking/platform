<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Department;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model implements Htmlable
{
    use SoftDeletes,
        Viewable,
        Routable,
        HasUuid;

    protected $table = 'addworking_common_regions';

    protected $fillable = [
        'slug_name',
        'display_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public static function options()
    {
        return self::orderBy('display_name', 'asc')->get()->mapWithKeys(function ($regions) {
            return [$regions->id => "{$regions->display_name}"];
        });
    }

    public static function optionsWithDepartments()
    {
        $regions = [];

        foreach (self::orderBy('display_name', 'asc')->with('departments')->get() as $region) {
            $regions[$region->display_name] = $region->departments->pluck('name', 'id');
        }

        return $regions;
    }
}
