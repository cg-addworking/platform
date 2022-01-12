<?php

namespace App\Models\Addworking\Mission\Concerns\PurchaseOrder;

trait HasStatuses
{
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_SENT
        ];
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isSent()
    {
        return $this->status == self::STATUS_SENT;
    }
}
