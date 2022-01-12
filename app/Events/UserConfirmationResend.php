<?php

namespace App\Events;

use App\Contracts\Events\UserAwareEvent;
use App\Models\Addworking\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserConfirmationResend implements UserAwareEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Concerns\HasUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->setUser($user);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
