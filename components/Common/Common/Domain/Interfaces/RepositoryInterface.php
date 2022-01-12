<?php

namespace Components\Common\Common\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;

interface RepositoryInterface
{
    public function find(string $uuid): EntityInterface;

    public function make(): EntityInterface;

    public function save(EntityInterface $entity): bool;
}
