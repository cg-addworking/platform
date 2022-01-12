@extends('layouts.app')

@section('id', 'address-edit')

@section('content')
@component('components.panel')
    <h1 class="m-0">{{ __('addworking.common.address.edit.edit_title') }}</h1>
@endcomponent

<form action="{{ route('address.save') }}"  method="post" class="form">
    {{ csrf_field() }}

    @component('components.panel')
        {{ $address->views->form }}
    @endcomponent

    @component('components.panel', ['class' => 'default pull-right'])
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ __('addworking.common.address.edit.save') }}</button>
    @endcomponent
@endsection
