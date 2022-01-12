<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Mission\Milestone;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MilestoneRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MilestoneRepository implements MilestoneRepositoryInterface
{
    public function find(string $uuid): MilestoneEntityInterface
    {
        return Milestone::findOrFail($uuid);
    }

    public function make(): MilestoneEntityInterface
    {
        return new Milestone;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof MilestoneEntityInterface) {
            throw new \RuntimeException("unable to save an instance of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }
}
