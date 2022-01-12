<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TrackingLineRepository implements TrackingLineRepositoryInterface
{
    public function find(string $uuid): TrackingLineEntityInterface
    {
        return MissionTrackingLine::findOrFail($uuid);
    }

    public function make(): TrackingLineEntityInterface
    {
        return new MissionTrackingLine;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof TrackingLineEntityInterface) {
            throw new \RuntimeException("unable to save instances of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }
}
