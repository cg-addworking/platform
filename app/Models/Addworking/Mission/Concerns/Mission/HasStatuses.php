<?php

namespace App\Models\Addworking\Mission\Concerns\Mission;

trait HasStatuses
{
    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DONE,
            self::STATUS_ABANDONED,
            self::STATUS_CLOSED,
            self::STATUS_READY_TO_START
        ];
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isInProgress()
    {
        return $this->status == self::STATUS_IN_PROGRESS;
    }

    public function isDone()
    {
        return $this->status == self::STATUS_DONE;
    }

    public function isAbandoned()
    {
        return $this->status == self::STATUS_ABANDONED;
    }

    public function isClosed()
    {
        return $this->status == self::STATUS_CLOSED;
    }

    public function isReadyToStart()
    {
        return $this->status == self::STATUS_READY_TO_START;
    }
}
