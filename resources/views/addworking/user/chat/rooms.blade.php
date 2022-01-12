@php
    $and = false;
@endphp

@extends('layouts.app')

@section('id', 'enterprise-index')

@section('title')
    @component('components.panel')
        <div class="row">
            <div class="col-md-9">
                @if(!auth()->user()->isSupport() || "chat.roomsAdmin" != Route::currentRouteName())
                    <h1>{{ __('addworking.user.chat.rooms.chatroom_list_participate') }}</h2>
                @else
                    <h1>{{ __('addworking.user.chat.rooms.chatroom_list') }}</h2>
                @endif

            </div>
        </div>
    @endcomponent
@endsection
@section('content')
    @if(count($usersConversation) > 0)
        @component('components.panel')
            <div class="row">
                <div class="col-md-12">
                @foreach($usersConversation as $conversation)
                    @php
                        $users = $conversation->users()->get();
                    @endphp
                    @if((Auth::user()->isSystemSuperadmin() || Auth::user()->isSystemAdmin() || Auth::user()->isSystemOperator()) && "chat.roomsAdmin" == Route::currentRouteName())
                        <p>
                            <div class="col-md-9">
                                <b>Conversation entre
                                @foreach($users as $user)
                                    @if($and)
                                        et
                                    @endif
                                    <a href="{{ route('user.show', $user->id ) }}">
                                        <span class="text-warning"> {{ $user->firstname }} {{ $user->lastname }}</span>
                                    </a>
                                    @if($user->enterprise->id)
                                        <a href="{{ route('enterprise.show', $user->enterprise->id ) }}">(<i>{{ $user->enterprise->name }}</i>)</span>
                                        </a>
                                    @endif
                                    @php
                                        $and = true;
                                    @endphp
                                @endforeach
                                @php
                                    $and = false;
                                @endphp
                                </b>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('chatAdmin', $conversation->id) }}">
                                    <button class="btn btn-primary pull-right">{{ __('addworking.user.chat.rooms.see_conversation') }}</button>
                                </a>
                            </div>
                        </p>
                        <br><br>
                    @else
                        <p>
                        @foreach($users as $user)
                            @if($user->id != Auth::user()->id)
                                <b>{{ __('addworking.user.chat.rooms.conversation_with') }}
                                    <a href="{{ route('user.show', $user->id) }}">
                                        <span class="text-warning">{{ $user->firstname}} {{ $user->lastname }}</span>
                                    </a>
                                    @if($user->enterprise->id)
                                        <a href="{{ route('enterprise.show', $user->enterprise->id) }}">
                                            (<i>{{ $user->enterprise->name }}</i>)
                                        </a>
                                    @endif
                                </b>
                                 <a href="{{ route('chat', [$user->id, $conversation->id]) }}">
                                    <button class="btn btn-primary pull-right">{{ __('addworking.user.chat.rooms.see_conversation') }}</button>
                                 </a>
                            @endif
                            </p>
                        @endforeach
                        <br>
                    @endif
                @endforeach
                </div>
            </div>
        @endcomponent
    @endif
        @if((Auth::user()->isSystemSuperadmin() || Auth::user()->isSystemAdmin() || Auth::user()->isSystemOperator()) && "chat.roomsAdmin" == Route::currentRouteName())
            @component('components.panel')
                <div class="row">
                    <div class="col-md-9">
                         <a href="{{ route('chat.rooms') }}"><button type="submit" class="btn btn-primary">{{ __('addworking.user.chat.rooms.access_your_conversation') }}</button></a>
                    </div>
                </div>
            @endcomponent
        @endif
@endsection
