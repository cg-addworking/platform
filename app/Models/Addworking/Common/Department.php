<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Region;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model implements Htmlable
{
    use SoftDeletes,
        Viewable,
        Routable,
        HasUuid;

    protected $table = 'addworking_common_departments';

    protected $fillable = [
        'region_id',
        'slug_name',
        'display_name',
        'insee_code',
        'prefecture',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function activities()
    {
        return $this->belongsToMany(
            EnterpriseActivity::class,
            'addworking_enterprise_activities_has_departments',
            'department_id',
            'activity_id'
        );
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getNameAttribute()
    {
        return vsprintf('(%s) %s', [
            $this->insee_code,
            $this->display_name,
        ]);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public static function options()
    {
        return self::orderBy('insee_code', 'asc')
            ->get()
            ->mapWithKeys(function ($department) {
                return [
                    $department->id => "({$department->insee_code}) {$department->display_name}",
                ];
            });
    }

    public static function inseeCodesOptions()
    {
        return self::orderBy('insee_code', 'asc')
            ->get()
            ->mapWithKeys(function ($department) {
                return [
                    $department->insee_code => "({$department->insee_code}) {$department->display_name}",
                ];
            });
    }

    public static function fromInseeCode(string $code): Department
    {
        if (strlen($code) == 1) {
            $code = "0{$code}";
        }

        return self::where('insee_code', $code)->firstOrFail();
    }
}
