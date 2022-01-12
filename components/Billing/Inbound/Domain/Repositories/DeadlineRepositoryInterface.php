<?php

namespace Components\Billing\Inbound\Domain\Repositories;

interface DeadlineRepositoryInterface
{
    public function findByName(string $name);
}
