@extends('layouts.app')

@section('id', 'enterprise-activity-index')

@section('content')
    @component('components.panel')
        <h1 class="mb-0">@lang('enterprise.enterprise_activity.title')</h1>
    @endcomponent

    @foreach($activities as $activity)
        @component('components.panel')
        {!! $activity !!}
        @endcomponent
    @endforeach

@endsection
