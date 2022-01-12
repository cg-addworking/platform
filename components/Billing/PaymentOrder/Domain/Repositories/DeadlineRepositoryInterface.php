<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

interface DeadlineRepositoryInterface
{
    public function findByName(string $name);
}
