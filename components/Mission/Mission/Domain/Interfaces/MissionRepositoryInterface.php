<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use App\Models\Addworking\Mission\MissionCollection;
use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;

interface MissionRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): MissionEntityInterface;

    public function findByIds(array $ids): MissionCollection;

    public function make(): MissionEntityInterface;
}
