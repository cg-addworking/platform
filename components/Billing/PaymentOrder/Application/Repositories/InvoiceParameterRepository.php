<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Billing\PaymentOrder\Domain\Repositories\InvoiceParameterRepositoryInterface;

class InvoiceParameterRepository implements InvoiceParameterRepositoryInterface
{
    public function findByEnterprise($entreprise)
    {
        return InvoiceParameter::whereHas('enterprise', function ($query) use ($entreprise) {
            $query->where('id', $entreprise->id);
        })->isActive()->latest()->first();
    }
}
