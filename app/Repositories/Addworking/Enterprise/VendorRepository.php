<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VendorRepository extends BaseRepository
{
    protected $model = Enterprise::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Enterprise::query()
            ->when($filter['name'] ?? null, function ($query, $enterprise) {
                return $query->ofName($enterprise);
            })
            ->when($filter['legal_representative'] ?? null, function ($query, $user) {
                return $query->ofLegalRepresentative($user);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public static function getAvailableVendors(): Collection
    {
        return Enterprise::where('is_vendor', true)
            ->where('name', '!=', '')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function isVendor(Enterprise $enterprise): bool
    {
        return $enterprise->is_vendor;
    }

    public function isVendorOf(Enterprise $vendor, Enterprise $customer): bool
    {
        return $vendor->customers()->where('id', $customer->id)->exists();
    }

    public function hasVendors(Enterprise $enterprise): bool
    {
        return $enterprise->vendors()->exists();
    }
}
