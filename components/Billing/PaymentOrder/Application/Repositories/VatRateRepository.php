<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\VatRate;
use Components\Billing\PaymentOrder\Domain\Repositories\VatRateRepositoryInterface;

class VatRateRepository implements VatRateRepositoryInterface
{
    public function findByValue(float $value)
    {
        return VatRate::where('value', $value)->first();
    }
}
