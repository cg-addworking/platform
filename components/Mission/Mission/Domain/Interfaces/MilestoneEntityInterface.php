<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;

interface MilestoneEntityInterface extends EntityInterface
{
    public function belongsToMission(MissionEntityInterface $mission): bool;

    const MILESTONE_WEEKLY = "weekly";
    const MILESTONE_MONTHLY = "monthly";
    const MILESTONE_QUARTERLY = "quarterly";
    const MILESTONE_ANNUAL = "annual";
    const MILESTONE_END_OF_MISSION = "end_of_mission";

    public static function getAvailableMilestoneTypes(): array;
}
