<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

interface InvoiceParameterRepositoryInterface
{
    public function findByEnterprise($entreprise);
}
