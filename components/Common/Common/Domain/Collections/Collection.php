<?php

namespace Components\Common\Common\Domain\Collections;

use Components\Common\Common\Domain\Interfaces\CollectionInterface;
use Components\Common\Common\Domain\Interfaces\EntityInterface;

abstract class Collection implements CollectionInterface
{
    protected $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage;
    }

    abstract protected function accept(EntityInterface $item): bool;

    public function count(): int
    {
        return count($this->storage);
    }

    public function getIterator(): \Generator
    {
        yield from $this->storage;
    }

    public function contains(EntityInterface $object): bool
    {
        return $this->storage->contains($object);
    }

    public function filter(callable $fn): CollectionInterface
    {
        return $this->merge(new \CallbackFilterIterator($this->storage, $fn));
    }

    public function merge(iterable $collection): CollectionInterface
    {
        $cloned = clone $this;

        foreach ($collection as $item) {
            $cloned->push($item);
        }

        return $cloned;
    }

    public function push(EntityInterface $object): void
    {
        if (! $this->accept($object)) {
            throw new \InvalidArgumentException("Unacceptable object");
        }

        $this->storage->attach($object);
    }

    public function remove(EntityInterface $object): void
    {
        if (! $this->accept($object)) {
            throw new \InvalidArgumentException("Unacceptable object");
        }

        $this->storage->detach($object);
    }
}
