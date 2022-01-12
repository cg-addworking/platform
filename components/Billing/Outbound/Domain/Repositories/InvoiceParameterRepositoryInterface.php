<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface InvoiceParameterRepositoryInterface
{
    public function findByEnterprise($entreprise);
    public function findByEnterpriseSiret(string $siret);
    public function getActiveParameterInPeriod(Enterprise $entreprise, string $period);
}
