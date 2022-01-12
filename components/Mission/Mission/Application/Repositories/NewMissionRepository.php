<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Domain\Exceptions\MissionCreationFailedException;
use Components\Mission\Mission\Domain\Interfaces\Entities\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\MissionRepositoryInterface;

class NewMissionRepository implements MissionRepositoryInterface
{
    public function make(): MissionEntityInterface
    {
        return new Mission;
    }

    public function save(MissionEntityInterface $mission)
    {
        try {
            $mission->save();
        } catch (MissionCreationFailedException $exception) {
            throw $exception;
        }

        $mission->refresh();

        return $mission;
    }

    public function createFiles($files, MissionEntityInterface $mission)
    {
        foreach ($files as $content) {
            $file = File::saveAndSendToStorage($content);
            $mission->files()->attach($file->id);
        }
    }

    public function isOwnerOfMission($enterprises, MissionEntityInterface $mission): bool
    {
        if (! empty($enterprises)) {
            return $enterprises->contains($mission->getCustomer());
        }

        return false;
    }

    public function deleteFile(File $file)
    {
        return $file->delete();
    }

    public function findByNumber($number): ?MissionEntityInterface
    {
        return Mission::where('number', $number)->first();
    }
}
