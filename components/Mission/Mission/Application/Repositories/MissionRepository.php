<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionCollection;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MissionRepository implements MissionRepositoryInterface
{
    public function find(string $uuid): MissionEntityInterface
    {
        return Mission::findOrFail($uuid);
    }

    public function findByIds(array $ids): MissionCollection
    {
        return Mission::find($ids);
    }

    public function make(): MissionEntityInterface
    {
        return new Mission;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof MissionEntityInterface) {
            throw new \RuntimeException("unable to save an instance of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }
}
