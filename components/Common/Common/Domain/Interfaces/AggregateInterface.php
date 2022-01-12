<?php

namespace Components\Common\Common\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;

interface AggregateInterface extends EntityInterface
{
    public function getRoot(): EntityInterface;

    public function setRoot(EntityInterface $entity): void;
}
