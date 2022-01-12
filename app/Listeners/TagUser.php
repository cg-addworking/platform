<?php

namespace App\Listeners;

use App\Events\UserCreated;

class TagUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if (session()->pull('utm_source') == 'soconnext-moins-15-salaries') {
            $event->user->tag('sogetrel.soconnext');
        }
    }
}
