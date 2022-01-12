@extends('layouts.app')

@section('id', 'enterprise-index')

@section('title')
    @if(isset($user))
        @component('components.panel')
            <div class="row">
                <div class="col-md-9">
                    <h1>{{ __('addworking.user.chat.index.converse') }} <span class="text-warning">{{ $user->views->link }}</span><br>({{ $user->enterprise->views->link }})</h1>
                </div>
                <div class="col-md-8 text-right">
                </div>
            </div>
        @endcomponent
    @endif
@endsection

@section('content')
    @if(isset($messages))
        @component('components.panel',  ['body' => true])
            <div style="position: relative; padding-bottom: 55px;" class="row">
                <div class="col-md-12 ">
                @foreach($messages as $message)
                    @php
                        $className = (Auth::User()->name == $message->user->firstname . " " . $message->user->lastname)? 'text-right text-danger' : 'text-left text-warning';
                        $classMessage = (Auth::User()->name == $message->user->firstname . " " . $message->user->lastname)? 'text-right' : 'text-left';
                    @endphp
                    <p {!! attr(['class' => $className]) !!} style="font-size:1.5em;">
                        <u>{{ $message->user->firstname . " " . $message->user->lastname }}</u>
                    </p>
                    <p {!! attr(['class' => $classMessage]) !!} >
                        <b>{{ $message->message }}</b>
                        @if($message->file_id)
                            <a href="{{ route('file.show', $message->file_id)}}" class="btn btn-primary">{{ __('addworking.user.chat.index.view_document') }}</a>
                        @endif
                        <br />
                        <i>{{ __('addworking.user.chat.index.sent') }} {{time_elapsed_until_now($message->created_at) }}</i>
                    </p>
                    <br />
                @endforeach
                </div>
            </div>
        @endcomponent
    @endif
    <div style="position: fixed; bottom: -22px; width: 80%;">
    @if(isset($user))
        @component('components.panel')
            <form method="post" action="{{ route('chat.save_message') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="message[receiver]" value="{{ $user->id }}">
                <input type="hidden" name="message[user_id]" value="{{ Auth::user()->id }}">
                <input type="hidden" name="message[name]" value="{{ Auth::user()->id }}{{ $user->id }}">
                <div class="col-md-9 ">
                    <p><input type="text" class="form-control" name="message[message]" placeholder="Message..."></p>
                    <p><input type="file" class="form-control" name="file[content]" accept="application/pdf"></p>
                    <input type="hidden" name="file[path]" value="chat/{{ rand (1 , 9999999999) }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">{{ __('addworking.user.chat.index.to_send') }}</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-secondary" onclick='window.location.reload(false)' value="{{ __('addworking.user.chat.index.refresh') }}"/>{{ __('addworking.user.chat.index.refresh') }}</button>
                </div>
            </form>
        @endcomponent
    @endif
     </div>
@endsection
