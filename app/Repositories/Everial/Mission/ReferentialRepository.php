<?php

namespace App\Repositories\Everial\Mission;

use App\Contracts\Models\Repository;
use App\Models\Everial\Mission\Referential;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ReferentialRepository extends BaseRepository
{
    protected $model = Referential::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Referential::query()
            ->when($filter['shipping_site'] ?? null, function ($query, $shipping_site) {
                return $query->shippingSite($shipping_site);
            })
            ->when($filter['shipping_address'] ?? null, function ($query, $shipping_address) {
                return $query->shippingAddress($shipping_address);
            })
            ->when($filter['destination_site'] ?? null, function ($query, $destination_site) {
                return $query->destinationSite($destination_site);
            })
            ->when($filter['destination_address'] ?? null, function ($query, $destination_address) {
                return $query->destinationAddress($destination_address);
            })
            ->when($filter['pallet_number'] ?? null, function ($query, $pallet_number) {
                return $query->palletNumber($pallet_number);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request): Referential
    {
        $referential = $this->make();
        $referential->fill($request->input('referential'));
        $referential->save();

        return $referential;
    }

    public function updateFromRequest(Request $request, Referential $referential): Referential
    {
        $referential->fill($request->input('referential'));
        $referential->bestBidder()->associate($request->input('referential.best_bidder'));
        $referential->save();

        return $referential;
    }
}
