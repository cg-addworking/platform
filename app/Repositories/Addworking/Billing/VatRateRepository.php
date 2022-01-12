<?php

namespace App\Repositories\Addworking\Billing;

use App\Contracts\Models\Repository;
use App\Repositories\BaseRepository;
use App\Models\Addworking\Billing\VatRate;
use Illuminate\Http\Request;

class VatRateRepository extends BaseRepository
{
    protected $model = VatRate::class;

    public function createFromRequest(Request $request): VatRate
    {
        return $this->updateFromRequest($request, $this->make());
    }

    public function updateFromRequest(Request $request, VatRate $vat_rate): VatRate
    {
        return tap($vat_rate, function ($rate) use ($request) {
            $rate->fill([
                'name'  => $request->input('vat_rate.display_name'),
                'value' => $request->input('vat_rate.value') / 100,
            ] + $request->input('vat_rate'))->save();
        });
    }
}
