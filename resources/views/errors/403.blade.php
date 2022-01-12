@extends('foundation::layout.app')

@section('main')
    <h1>{{ __('errors.error_403.access_denied') }}</h1>
    <p>{{ __('errors.error_403.text_line1') }} <a href="mailto:support+technique{{'@'}}addworking.com?subject=403%20sur%20{!! urlencode(app()->environment()) !!}&body=URL:%20{!! urlencode(url()->full()) !!}%0ADepuis:%20{!! urlencode(url()->previous()) !!}%0AUID:{{ auth()->check() ? auth()->user()->id : '--' }}%0A" target="_blank">{{ __('errors.error_403.technical_service') }}</a></p>
    <p><a href="{{ url()->previous() }}">{{ __('errors.error_403.go_back_to_previous_page') }}</a> · <a href="/">{{ __('errors.error_403.go_to_homepage') }}</a></p>
@endsection
