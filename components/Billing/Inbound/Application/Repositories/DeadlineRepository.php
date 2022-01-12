<?php

namespace Components\Billing\Inbound\Application\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use Components\Billing\Inbound\Domain\Repositories\DeadlineRepositoryInterface;

class DeadlineRepository implements DeadlineRepositoryInterface
{
    public function findByName(string $name)
    {
        return DeadlineType::where('name', $name)->first();
    }
}
