<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

interface VatRateRepositoryInterface
{
    public function findByValue(float $value);
}
