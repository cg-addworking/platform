<?php

namespace Components\Common\Common\Domain\Collections;

use Components\Common\Common\Domain\Collections\Collection;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Common\Common\Domain\Interfaces\FileCollectionInterface;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;

class FileCollection extends Collection implements FileCollectionInterface
{
    public function accept(EntityInterface $object): bool
    {
        return $object instanceof FileImmutableInterface;
    }
}
