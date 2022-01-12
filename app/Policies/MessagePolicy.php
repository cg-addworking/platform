<?php

namespace App\Policies;

use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can acces all chat room.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return boolean
     */
    public function chatRoomAdmin(User $user)
    {
        return $user->isSupport();
    }

    /**
     * Determine whether the user can view the chat room.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return boolean
     */
    public function chatRoom(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view his message.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return boolean
     */
    public function chat(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view all chat room.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return boolean
     */
    public function chatAdmin(User $user)
    {
        return $user->isSupport();
    }

    /**
     * Determine whether the user can save a message.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return boolean
     */
    public function store(User $user)
    {
        return true;
    }
}
