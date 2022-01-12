<?php

namespace Components\Common\Common\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;

interface CollectionInterface extends \Countable, \IteratorAggregate
{
    public function contains(EntityInterface $object): bool;

    public function filter(callable $fn): self;

    public function merge(iterable $collection): self;

    public function push(EntityInterface $object): void;

    public function remove(EntityInterface $object): void;
}
