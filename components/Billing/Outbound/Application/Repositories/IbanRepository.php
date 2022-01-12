<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Enterprise\Iban;
use Components\Billing\Outbound\Domain\Repositories\IbanRepositoryInterface;

class IbanRepository implements IbanRepositoryInterface
{
    public function findByEnterprise($enterprise)
    {
        return Iban::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->approved()->latest()->first();
    }

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
}
