@extends('layouts.app')

@section('id', 'sogetrel-user-passwork-show')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('_form_errors')

            @component('components.panel')
                @slot('heading')
                    {{ __('sogetrel.user.passwork.log.edit.edit_message') }}
                @endslot
                <form action="{{ route('sogetrel.passwork.log.update', ['passwork' => $log->passwork_id, 'log' => $log->id]) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="passwork_id" value="{{ $log->passwork_id }}">
                    <input type="hidden" name="user_id" value="{{ $log->user_id }}">
                    <input type="hidden" name="passwork_log_id" value="{{ $log->id }}">

                    <label>{{ __('sogetrel.user.passwork.log.edit.the_message') }}</label>
                    <textarea class="form-control" type="text" name="message" rows="5"/> {{ $log->message}}</textarea>
                    <br>
                    <button type="submit" class="btn btn-primary" >{{ __('sogetrel.user.passwork.log.edit.save') }}</button>
                </form>
            @endcomponent
        </div>
    </div>
@endsection
