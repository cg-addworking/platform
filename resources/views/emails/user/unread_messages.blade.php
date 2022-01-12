@component('mail::message')

{{ __('emails.user.unread_messages.hello') }} {{ $user->name }},

{{ __('emails.user.unread_messages.text_line1') }}

@component('mail::button', ['url' => route('chat.rooms')])
    {{ __('emails.user.unread_messages.access_message') }}
@endcomponent

@foreach( $chatRoomsMessages as $room => $chatRoomMessages )

#{{ __('emails.user.unread_messages.conversation_with') }} {!! $room !!}

@foreach($chatRoomMessages as $chatRoom => $messages)
@php
    $user = App\Models\Addworking\User\User::find($messages['author']);
@endphp

**{!! $user->name !!}**

*{!! $messages['message'] !!}*

@endforeach
@component('mail::button', ['url' => route('chat', $user->id)])
    {{ __('emails.user.unread_messages.access_conversation') }}
@endcomponent
@endforeach

@endcomponent
