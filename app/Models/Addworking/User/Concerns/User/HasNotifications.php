<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\User\NotificationPreferences;

trait HasNotifications
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreferences::class)->withDefault();
    }
}
