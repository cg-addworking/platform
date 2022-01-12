<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Billing\DeadlineType;

interface DeadlineRepositoryInterface
{
    public function findByName(string $name);

    public function calculDueAt(DeadlineType $deadline, string $invoicedAt, ?string $dueAt = null);

    public function getDeadlines(): array;
}
