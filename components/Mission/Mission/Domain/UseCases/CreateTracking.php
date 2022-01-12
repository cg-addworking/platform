<?php

namespace Components\Mission\Mission\Domain\UseCases;

use Components\Mission\Mission\Domain\Interfaces\MilestoneEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingRepositoryInterface;
use Components\User\User\Domain\Interfaces\UserEntityInterface;

class CreateTracking
{
    protected $trackings;

    public function __construct(TrackingRepositoryInterface $trackings)
    {
        $this->trackings = $trackings;
    }

    public function handle(
        MissionEntityInterface $mission,
        MilestoneEntityInterface $milestone,
        UserEntityInterface $user = null,
        array $data = []
    ): TrackingEntityInterface {
        $data += [
            'status' => TrackingEntityInterface::STATUS_PENDING,
        ];

        $tracking = $this->trackings->make()
            ->setMission($mission)
            ->setMilestone($milestone)
            ->setUser($user)
            ->setStatus($this->getStatus($data))
            ->setDescription($this->getDescription($data))
            ->setExternalId($this->getExternalId($data));

        if (! $this->trackings->save($tracking)) {
            throw new \RuntimeException("unable to create new tracking");
        }

        return $tracking;
    }

    private function getStatus(array $data): string
    {
        if (! isset($data['status'])) {
            throw new \RuntimeException(
                "invalid data: missing key 'status'"
            );
        }

        return $this->validateStatus($data['status']);
    }

    private function validateStatus(string $status): string
    {
        if (! in_array($status, $statuses = $this->trackings->make()->getAvailableStatuses())) {
            throw new \UnexpectedValueException(
                "invalid status: '{$status}', ".
                "valid statuses are [".implode(',', $statuses)."]"
            );
        }

        return $status;
    }

    private function getDescription(array $data): ?string
    {
        return $data['description'] ?? null;
    }

    private function getExternalId(array $data): ?string
    {
        return $data['external_id'] ?? null;
    }
}
