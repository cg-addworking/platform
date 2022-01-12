<?php
namespace Components\Enterprise\InvoiceParameter\Application\Repositories;

use App\Models\Addworking\Enterprise\Iban;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\IbanRepositoryInterface;

class IbanRepository implements IbanRepositoryInterface
{
    public function make($data = [])
    {
        $class = Iban::class;

        return new $class($data);
    }

    public function find(string $id)
    {
        return Iban::where('id', $id)->first();
    }

    public function findByEnterprise($enterprise)
    {
        return Iban::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->approved()->latest()->first();
    }

    public function getAllByEnterprise($enterprise)
    {
        return Iban::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->approved()->latest()->get();
    }
}
