<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;

interface TrackingRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): TrackingEntityInterface;

    public function make(): TrackingEntityInterface;
}
