<?php

namespace Components\Enterprise\Resource\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Domain\Classes\ActivityPeriodInterface;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use DateTime;
use Illuminate\Support\Facades\App;

class CreateActivityPeriod
{
    public function handle(
        ResourceInterface $resource,
        Enterprise $enterprise,
        DateTime $starts_at,
        DateTime $ends_at
    ): bool {
        $period = App::make(ActivityPeriodInterface::class);

        $period->setResource($resource);
        $period->setCustomer($enterprise);
        $period->setStartsAt($starts_at);
        $period->setEndsAt($ends_at);

        return $period->save();
    }
}
