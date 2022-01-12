<?php
namespace Components\Billing\Outbound\Domain\Repositories;

interface VatRateRepositoryInterface
{
    public function findByValue(float $value);

    public function getVatRates();
}
