<?php

namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use Components\Billing\PaymentOrder\Domain\Repositories\DeadlineRepositoryInterface;

class DeadlineRepository implements DeadlineRepositoryInterface
{
    public function findByName(string $name)
    {
        return DeadlineType::where('name', $name)->first();
    }
}
