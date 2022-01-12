<?php

namespace App\Models\Addworking\Mission\Concerns\Proposal;

trait HasStatuses
{
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_RECEIVED,
            self::STATUS_INTERESTED,
            self::STATUS_UNDER_NEGOTIATION,
            self::STATUS_ACCEPTED,
            self::STATUS_REFUSED,
            self::STATUS_ASSIGNED,
            self::STATUS_ABANDONED,
            self::STATUS_ANSWERED,
            self::STATUS_BPU_SENDED,
        ];
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isUnderNegotiation()
    {
        return $this->status == self::STATUS_UNDER_NEGOTIATION;
    }

    public function isAccepted()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    public function isRefused()
    {
        return $this->status == self::STATUS_REFUSED;
    }

    public function isAssigned()
    {
        return $this->status == self::STATUS_ASSIGNED;
    }

    public function isAbandoned()
    {
        return $this->status == self::STATUS_ABANDONED;
    }

    public function isAnswered()
    {
        return $this->status == self::STATUS_ANSWERED;
    }

    public function isInterested()
    {
        return $this->status == self::STATUS_INTERESTED;
    }

    public function isReceived()
    {
        return $this->status == self::STATUS_RECEIVED;
    }

    public function isBpuSended()
    {
        return $this->status == self::STATUS_BPU_SENDED;
    }
}
