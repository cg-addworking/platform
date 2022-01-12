<?php

namespace App\Models\Addworking\User;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\ChatMessage;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = 'addworking_user_chat_rooms';

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return (string) $this->name;
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'addworking_user_chat_rooms_has_addworking_user_users',
            'chat_room_id',
            'user_id'
        )
            ->withTimestamps();
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id');
    }
}
