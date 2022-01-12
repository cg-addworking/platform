<?php

namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use Carbon\Carbon;
use Components\Billing\Outbound\Domain\Repositories\DeadlineRepositoryInterface;

class DeadlineRepository implements DeadlineRepositoryInterface
{
    public function findByName(string $name)
    {
        return DeadlineType::where('name', $name)->first();
    }

    public function calculDueAt(DeadlineType $deadline, string $invoicedAt, ?string $dueAt = null)
    {
        if (is_null($dueAt)) {
            return Carbon::createFromFormat('Y-m-d', $invoicedAt)->addDays($deadline->value)->endOfDay();
        }

        return Carbon::createFromFormat('Y-m-d', $dueAt)->endOfDay();
    }

    public function getDeadlines(): array
    {
        return DeadlineType::all()->pluck('display_name', 'name')->toArray();
    }
}
