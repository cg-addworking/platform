<?php

namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Billing\Outbound\Domain\Repositories\InvoiceParameterRepositoryInterface;

class InvoiceParameterRepository implements InvoiceParameterRepositoryInterface
{
    public function findByEnterprise($entreprise)
    {
        return InvoiceParameter::whereHas('enterprise', function ($query) use ($entreprise) {
            $query->where('id', $entreprise->id);
        })->isActive()->latest()->first();
    }

    public function findByEnterpriseSiret(string $siret)
    {
        return InvoiceParameter::whereHas('enterprise', function ($query) use ($siret) {
            $query->where('identification_number', $siret);
        })->isActive()->latest()->first();
    }

    public function getActiveParameterInPeriod(Enterprise $entreprise, string $period)
    {
        return InvoiceParameter::whereHas('enterprise', function ($query) use ($entreprise) {
            $query->where('id', $entreprise->id);
        })->IsActiveInPeriod($period)->latest()->first();
    }
}
