<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\User\ChatMessage;
use App\Models\Addworking\User\ChatRoom;
use App\Models\Addworking\User\User;

trait HasChats
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function readMessages()
    {
        return $this->belongsToMany(User::class, 'addworking_user_has_read_messages');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chatRooms()
    {
        return $this->belongsToMany(
            ChatRoom::class,
            'addworking_user_chat_rooms_has_addworking_user_users',
            'user_id',
            'chat_room_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
