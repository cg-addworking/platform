<?php

namespace App\Models\Addworking\User;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\ChatRoom;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ChatMessage extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable,
        SoftDeletes;

    protected $table = 'addworking_user_chat_messages';

    protected $fillable = [
        'chat_room_id',
        'user_id',
        'message',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return (string)$this->message;
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userReadMessage()
    {
        return $this->belongsToMany(User::class, 'addworking_user_has_read_messages');
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    /**
     * @param User $user
     * @return bool
     */
    public function hasBeenReadBy(User $user)
    {
        $readMessages = DB::table('addworking_user_has_read_messages')
            ->where('chat_message_id', $this->id)
            ->where('user_id', $user->id)
            ->get();

        if (count($readMessages) > 0) {
            return true;
        }

        return false;
    }
}
