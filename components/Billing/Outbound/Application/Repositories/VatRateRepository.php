<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\VatRate;
use Components\Billing\Outbound\Domain\Repositories\VatRateRepositoryInterface;

class VatRateRepository implements VatRateRepositoryInterface
{
    public function findByValue(float $value)
    {
        return VatRate::where('value', $value)->first();
    }

    public function getVatRates()
    {
        return VatRate::get();
    }

    public function find(string $id)
    {
        return VatRate::where('id', $id)->first();
    }
}
