<?php

namespace App\Events\Concerns;

use App\Models\Addworking\User\User;

trait HasUser
{
    /**
     * User
     *
     * @var App\Models\Addworking\User\User
     */
    public $user;

    /**
     * Set the event's usre
     *
     * @param App\Models\Addworking\User\User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the event's user
     *
     * @return App\Models\Addworking\User\User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
