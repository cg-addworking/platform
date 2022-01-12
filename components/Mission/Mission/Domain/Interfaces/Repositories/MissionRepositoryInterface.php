<?php

namespace Components\Mission\Mission\Domain\Interfaces\Repositories;

use App\Models\Addworking\Common\File;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;

interface MissionRepositoryInterface
{
    public function make(): MissionEntityInterface;
    public function save(MissionEntityInterface $offer);
    public function createFiles($files, MissionEntityInterface $mission);
    public function isOwnerOfMission($enterprises, MissionEntityInterface $mission): bool;
    public function deleteFile(File $file);
    public function findByNumber($number): ?MissionEntityInterface;
}
