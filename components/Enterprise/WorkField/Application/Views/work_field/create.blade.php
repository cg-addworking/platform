@extends('foundation::layout.app.create', ['action' => route('work_field.store'), 'enctype' => "multipart/form-data"])

@section('title', __('work_field::workfield.create.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.create.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('work_field::work_field._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('work_field::work_field._form', ['page' => "create"])

    @button(__('work_field::workfield.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
