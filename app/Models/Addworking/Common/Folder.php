<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Generator;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Folder extends Model implements Htmlable, Searchable
{
    use HasUuid, Routable, Viewable;

    protected $table = "addworking_common_folders";
    protected $itemsTable = "addworking_common_folders_has_items";

    protected $fillable = [
        'name',
        'display_name',
        'shared_with_vendors',
    ];

    protected $casts = [
        'shared_with_vendors' => "boolean"
    ];

    protected $attributes = [
        'shared_with_vendors' => false
    ];

    protected $routePrefix = "addworking.common.folder";

    protected $viewPrefix = "addworking.common.folder";

    protected $searchable = [
        'display_name'
    ];

    public function __toString()
    {
        return (string) $this->display_name;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterUser($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeFilterUser($query, $user)
    {
        $user = strtolower($user);

        return $query->whereHas('createdBy', function ($query) use ($user) {
            return $query->where(DB::raw('LOWER(firstname) || LOWER(lastname)'), 'LIKE', "%{$user}%");
        });
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($q) use ($enterprise) {
            return $q->where('id', $enterprise->id);
        });
    }

    public function scopeOfCustomerEnterprises($query, Enterprise $enterprise)
    {
        return $query->whereHas(
            'enterprise',
            fn($q) => $q->whereIn('id', $enterprise->customers->pluck('id'))
        )->where('shared_with_vendors', true);
    }

    public function setDisplayNameAttribute(string $name)
    {
        $this->attributes['name'] = Str::slug($name);
        $this->attributes['display_name'] = $name;
    }

    public function link(Model $model): bool
    {
        return DB::table($this->itemsTable)->insert([
            'folder_id'  => $this->id,
            'item_id'    => $model->getKey(),
            'item_type'  => get_class($model),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function unlink(Model $model): bool
    {
        return DB::table($this->itemsTable)->where([
            'folder_id'  => $this->id,
            'item_id'    => $model->getKey(),
            'item_type'  => get_class($model),
        ])->delete();
    }

    public function getItems($where = null): Generator
    {
        $query = DB::table($this->itemsTable)
            ->where('folder_id', $this->id)
            ->latest();

        if (isset($where)) {
            $query->where($where);
        }

        foreach ($query->cursor() as $item) {
            $class = $item->item_type;
            $model = $class::find($item->item_id);

            yield $model;
        }
    }

    public function isSharedWithVendors(Folder $folder)
    {
        return $folder->attribute['shared_with_vendors'];
    }
}
