@extends('layouts.app')

@section('id', 'address-view')

@section('title')

    @component('components.panel')
        <h1 class="mb-0">{{ __('addworking.common.address.view.address') }}</h1>
    @endcomponent

@endsection

@section('content')

    @component('components.panel', ['class' => "success", 'icon' => "map-marker", 'collapse' => true])
        @slot('heading')
            {{ __('addworking.common.address.view.general_information') }}
        @endslot

        {{ $address->views->html }}
    @endcomponent
@endsection
