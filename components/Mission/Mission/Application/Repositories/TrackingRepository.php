<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Mission\MissionTracking;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TrackingRepository implements TrackingRepositoryInterface
{
    public function find(string $uuid): TrackingEntityInterface
    {
        return MissionTracking::findOrFail($uuid);
    }

    public function make(): TrackingEntityInterface
    {
        return new MissionTracking;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof TrackingEntityInterface) {
            throw new \RuntimeException("unable to save instances of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }
}
