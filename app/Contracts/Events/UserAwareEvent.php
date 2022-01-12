<?php

namespace App\Contracts\Events;

use App\Models\Addworking\User\User;

interface UserAwareEvent
{
    /**
     * Get the event's user
     *
     * @return App\Models\Addworking\User\User
     */
    public function getUser(): User;

    /**
     * Set the event's users
     *
     * @param App\Models\Addworking\User\User $user
     */
    public function setUser(User $user);
}
