<?php

namespace Components\Common\Common\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Common\Common\Domain\Exceptions\EntityNotFoundException;
use Components\Common\Common\Domain\Exceptions\UnableToSaveException;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Common\Common\Domain\Interfaces\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileRepository implements FileRepositoryInterface
{
    public function find(string $uuid): FileImmutableInterface
    {
        return File::findOrFail($uuid);
    }

    public function make(): FileImmutableInterface
    {
        return new File;
    }

    public function makeFrom(\SplFileInfo $file): FileImmutableInterface
    {
        return File::from($file);
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof FileImmutableInterface) {
            throw new UnableToSaveException("unable to save instances of " . get_class($entity));
        }

        try {
            $owner = $entity->getOwner();
        } catch (EntityNotFoundException | ModelNotFoundException $e) {
            throw new UnableToSaveException("unable to save file: missing owner", 0, $e);
        }

        if ($entity instanceof Model) {
            return $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }
}
