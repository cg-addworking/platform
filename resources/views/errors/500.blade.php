@extends('foundation::layout.app')

@section('main')
    <h1>{{ __('errors.error_500.internal_server_error') }}</h1>
    <p>{{ __('errors.error_500.text_line1') }} <a href="mailto:support+technique{{'@'}}addworking.com?subject=500%20sur%20{!! urlencode(app()->environment()) !!}&body=URL:%20{!! urlencode(url()->full()) !!}%0ADepuis:%20{!! urlencode(url()->previous()) !!}%0AUID:{{ auth()->check() ? auth()->user()->id : '--' }}%0A" target="_blank">{{ __('errors.error_500.technical_service') }}</a>. {{ __('errors.error_500.text_line2') }}</p>

    @isset($exception)
        <p>{{ __('errors.error_500.exception_text') }}:</p>
        @include('errors._exception')
    @endisset

    <p><a href="{{ url()->previous() }}">{{ __('errors.error_500.go_back_to_previous_page') }}</a> · <a href="/">{{ __('errors.error_500.go_to_homepage') }}</a></p>
@endsection
