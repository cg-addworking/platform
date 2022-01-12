<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use App\Models\Addworking\Enterprise\Iban;

class IbanRepository implements IbanRepositoryInterface
{
    public function find(string $id)
    {
        return Iban::where('id', $id)->first();
    }

    public function getAllIbansOf($enterprise)
    {
        return Iban::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->approved()->latest()->get();
    }

    public function findByEnterprise($enterprise)
    {
        return Iban::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->approved()->latest()->first();
    }
}
