<?php

namespace App\Models\Addworking\Mission;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\Concerns\PurchaseOrder\HasStatuses;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Model implements Htmlable, Searchable
{
    use SoftDeletes,
        HasUuid,
        Routable,
        Viewable,
        HasStatuses;

    const STATUS_DRAFT = 'draft';
    const STATUS_SENT  = 'sent';

    protected $table = 'addworking_mission_purchase_orders';

    protected $fillable = [
        'status',
    ];

    protected $routePrefix = 'enterprise.mission.purchase_order';

    protected $routeParameterAliases = [
        'enterprise' => 'customer',
    ];

    protected $searchable = [];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterMissionNumber($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterMissionLabel($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeFilterMissionNumber($query, $number)
    {
        return $query->whereHas('mission', function ($query) use ($number) {
            return $query->where('number', 'LIKE', "%{$number}%");
        });
    }

    public function scopeFilterMissionLabel($query, $label)
    {
        return $query->whereHas('mission', function ($query) use ($label) {
            return $query->where(DB::raw('LOWER(label)'), 'like', "%". strtolower($label)."%");
        });
    }
}
