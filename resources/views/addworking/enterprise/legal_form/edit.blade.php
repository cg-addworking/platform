@extends('foundation::layout.app.edit', ['action' => $legal_form->routes->update])

@section('title', __('addworking.enterprise.legal_form.edit.edit')." {$legal_form->display_name}")

@section('toolbar')
    @button(__('addworking.enterprise.legal_form.edit.return')."|href:{$legal_form->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.legal_form.edit.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $legal_form->routes->index }}">{{ __('addworking.enterprise.legal_form.edit.legal_form') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $legal_form->routes->show }}">{{ $legal_form->display_name }}</a></li>
    <li class="breadcrumb-item active">{{ __('addworking.enterprise.legal_form.edit.edit') }}</li>
@endsection

@section('form')
    @include('addworking.enterprise.legal_form._form', ['page' => 'edit'])

    @button(__('addworking.enterprise.legal_form.edit.record')."|icon:save|type:submit")
@endsection
