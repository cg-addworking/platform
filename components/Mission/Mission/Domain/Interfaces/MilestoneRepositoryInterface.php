<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;

interface MilestoneRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): MilestoneEntityInterface;

    public function make(): MilestoneEntityInterface;
}
