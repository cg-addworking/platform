<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnreadMessages extends Mailable
{
    use Queueable, SerializesModels;

    protected $chatRoomsMessages;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($chatRoomsMessages, $user)
    {
        $this->chatRoomsMessages = $chatRoomsMessages;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject(sprintf(
                'Vous avez des messages non lus sur la plateforme Addworking'
            ))
            ->markdown('emails.user.unread_messages')
            ->with([
                'user'                  => $this->user,
                'chatRoomsMessages'    => $this->chatRoomsMessages,
            ]);
    }
}
