<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineEntityInterface;

interface TrackingLineRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): TrackingLineEntityInterface;

    public function make(): TrackingLineEntityInterface;
}
