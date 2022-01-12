@extends('layouts.app')

@section('id', 'enterprise-activity-view')

@section('title')

    @component('components.panel')
        @if ($activity->exists)
            <h1 class="mb-0">{{ __('addworking.enterprise.enterprise_activity.edit.modify_activity') }} {{ $activity->enterprise->name }}</h1>
        @endif
    @endcomponent

@endsection

@section('content')

    <form action="{{ route('enterprise.activity.store',$enterprise) }}" method="post" class="form">
        {{ csrf_field() }}

        @if ($activity->exists)
            <input type="hidden" name="enterprise_activity[id]" value="{{ $activity->id }}">
        @endif

        @include('_form_errors')

        @component('components.panel', ['class' => "success", 'icon' => "trophy"])
            @slot('heading')
                {{ __('addworking.enterprise.enterprise_activity.edit.modify_activity') }} {{ $activity->enterprise->name }}
            @endslot

            {{ $activity->views->form }}
        @endcomponent

        @if ($activity->enterprise->exists && $activity->enterprise->signatories->count() == 0)
            @include('addworking.enterprise.enterprise_signatory._form', ['enterprise' => $activity->enterprise])
        @endif

        @component('components.panel', ['class' => 'default pull-right'])
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
        @endcomponent
    </form>
@endsection