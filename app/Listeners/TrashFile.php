<?php

namespace App\Listeners;

class TrashFile
{
    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $event->file->path = '/trash' . $event->file->path . '_' . uniqid("", true);
        $event->file->save();
    }
}
