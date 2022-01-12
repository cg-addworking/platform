<?php

namespace App\Models\Addworking\Mission\Concerns\Offer;

trait HasStatuses
{
    /**
     * Get available status for offer
     *
     * @return array
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_TO_PROVIDE,
            self::STATUS_COMMUNICATED,
            self::STATUS_CLOSED,
            self::STATUS_ABANDONED,
        ];
    }

    /**
     * Check if offer status is draft
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    /**
     * Check if offer status is to_provide
     *
     * @return bool
     */
    public function isToProvide()
    {
        return $this->status == self::STATUS_TO_PROVIDE;
    }

    /**
     * Check if offer status is communicated
     *
     * @return bool
     */
    public function isCommunicated()
    {
        return $this->status == self::STATUS_COMMUNICATED;
    }

    /**
     * Check if offer status is closed
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->status == self::STATUS_CLOSED;
    }

    /**
     * Check if offer status is abandoned
     *
     * @return bool
     */
    public function isAbandoned()
    {
        return $this->status == self::STATUS_ABANDONED;
    }
}
