<?php

namespace Components\Mission\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\User\User\Domain\Interfaces\UserEntityInterface;

interface TrackingEntityInterface extends EntityInterface
{
    public function getMission(): MissionEntityInterface;

    public function setMission(MissionEntityInterface $mission): self;

    public function getMilestone(): MilestoneEntityInterface;

    public function setMilestone(MilestoneEntityInterface $milestone): self;

    public function getUser(): ?UserEntityInterface;

    public function setUser(?UserEntityInterface $user): self;

    public function getStatus(): string;

    public function setStatus(string $status): self;

    public function getDescription(): ?string;

    public function setDescription(?string $description): self;

    public function getExternalId():?string;

    public function setExternalId(?string $external_id): self;

    const STATUS_PENDING = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_REFUSED = 'refused';
    const STATUS_SEARCH_FOR_AGREEMENT = 'search_for_agreement';

    public static function getAvailableStatuses(): array;
}
