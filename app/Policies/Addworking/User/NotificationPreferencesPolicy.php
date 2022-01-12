<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\User\User;
use App\Models\Addworking\User\NotificationPreferences;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPreferencesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the notification preferences.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\User\NotificationPreferences  $preferences
     * @return mixed
     */
    public function update(User $user, NotificationPreferences $preferences)
    {
        return $this->edit($user, $preferences);
    }

    /**
     * Determine whether the user can edit the notification preferences.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\User\NotificationPreferences  $preferences
     * @return mixed
     */
    public function edit(User $user, NotificationPreferences $preferences)
    {
        return $user->isSupport() || $preferences->user->is($user);
    }
}
