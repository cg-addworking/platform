<?php

namespace App\Http\Controllers\Addworking\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\User\SaveMessageRequest;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\ChatMessage;
use App\Models\Addworking\User\ChatRoom;
use App\Models\Addworking\User\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function chatRoomAdmin()
    {
        $this->authorize('chatRoomAdmin', ChatMessage::class);

        $usersConversation = ChatRoom::get();

        return view('addworking.user.chat.rooms', @compact('usersConversation'));
    }

    public function chatRoom()
    {
        $this->authorize('chatRoom', ChatMessage::class);

        $usersConversation = Auth::user()->chatRooms()->get();

        return view('addworking.user.chat.rooms', @compact('usersConversation'));
    }

    public function chatAdmin($rooms = null)
    {
        $this->authorize('chatAdmin', ChatMessage::class);

        $messages = null;

        if ($rooms) {
            $messages = ChatRoom::find($rooms)->chatMessages()->orderBy('created_at', 'DESC')->get();
        }

        return view('addworking.user.chat.index', @compact('messages'));
    }

    public function chat(User $user, $rooms = null)
    {
        $this->authorize('chat', ChatMessage::class);

        if ($rooms == null) {
            return view('addworking.user.chat.index', @compact('user'));
        }

        $messages = ChatRoom::find($rooms)->chatMessages()->orderBy('created_at', 'DESC')->get();

        foreach ($messages as $message) {
            if (Auth::user()->readMessages()->wherePivot('chat_message_id', $message->id)->count() == 0) {
                $message->userReadMessage()->attach(Auth::user()->id);
            }
        }

        return view('addworking.user.chat.index', @compact('user', 'messages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(SaveMessageRequest $request)
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail($request->input('message.receiver'));

        $chatRoom = $this->saveChatRoomData($request, $user);

        $this->saveChatMessageData($request, $chatRoom);

        return redirect()->route('chat', [$user, $chatRoom->id]);
    }

    protected function saveChatRoomData(SaveMessageRequest $request, User $user)
    {
        $chatRoom = ChatRoom::where('name', Auth::user()->id . $user->id)
            ->orWhere('name', $user->id . Auth::user()->id)
            ->first();

        if (!$chatRoom) {
            $chatRoom = new ChatRoom();
        }

        $chatRoom->fill($request->input('message'));
        $chatRoom->save();

        if ($user->chatRooms()->wherePivot('chat_room_id', $chatRoom->id)->count() == 0) {
            $chatRoom->users()->attach($user->id);
        }

        if (Auth::user()->chatRooms()->wherePivot('chat_room_id', $chatRoom->id)->count() == 0) {
            $chatRoom->users()->attach(Auth::user());
        }

        return $chatRoom;
    }

    protected function saveChatMessageData(SaveMessageRequest $request, ChatRoom $chatRoom)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->fill($request->input('message'));

        if (!$request->input('message.message')) {
            $chatMessage->fill(['message' => 'Un document à été envoyé']);
        }

        if ($request->has('file.content')) {
            $file = File::from($request->file('file.content'))
                ->name($request->input('file.path'))
                ->owner()->associate($request->user());

            $file->save();

            $chatMessage->file()->associate($file);
        }

        $chatMessage->chatRoom()->associate($chatRoom);
        $chatMessage->save();

        return $chatMessage;
    }
}
