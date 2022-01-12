@extends('layouts.app')

@section('id', 'enterprise-activity-view')
@section('content')
@component('components.panel')
    <h1 class="mb-0">@lang('enterprise.enterprise_activity.title')</h1>
@endcomponent

@component('components.panel')
    {!! $activity !!}
@endcomponent
@endsection
