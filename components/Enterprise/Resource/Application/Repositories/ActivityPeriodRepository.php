<?php

namespace Components\Enterprise\Resource\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Domain\Repositories\ActivityPeriodRepositoryInterface;

class ActivityPeriodRepository implements ActivityPeriodRepositoryInterface
{
    public function list(?array $filter = null, ?string $search = null)
    {
        return ActivityPeriod::query()
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter['last_name'] ?? null, function ($query, $last_name) {
                return $query->filterLastName($last_name);
            })
            ->when($filter['first_name'] ?? null, function ($query, $first_name) {
                return $query->filterFirstName($first_name);
            })
            ->when($filter['email'] ?? null, function ($query, $email) {
                return $query->filterEmail($email);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function make($data = []): ActivityPeriod
    {
        $class = ActivityPeriod::class;

        return new $class($data);
    }
}
