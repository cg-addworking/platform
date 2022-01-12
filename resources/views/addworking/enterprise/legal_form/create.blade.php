@extends('foundation::layout.app.create', ['action' => $legal_form->routes->store])

@section('title', __('addworking.enterprise.legal_form.create.create_legal_form'))

@section('toolbar')
    @button(__('addworking.enterprise.legal_form.create.return')."|href:{$legal_form->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.legal_form.create.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $legal_form->routes->index }}">{{ __('addworking.enterprise.legal_form.create.legal_form') }}</a></li>
    <li class="breadcrumb-item active">{{ __('addworking.enterprise.legal_form.create.create') }}</li>
@endsection

@section('form')
    @include('addworking.enterprise.legal_form._form', ['page' => 'create'])

    @button(__('addworking.enterprise.legal_form.create.create')."|icon:save|type:submit")
@endsection
