@extends('foundation::layout.app.create', ['action' => $document_type->routes->store, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.enterprise.document_type.create.create_new_document'))

@section('toolbar')
    @button(__('addworking.enterprise.document_type.create.return')."|href:{$document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document_type.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document_type.create.company').'|href:'.$enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item(__('addworking.enterprise.document_type.create.document_type_management').'|href:'.$document_type->routes->index )
    @breadcrumb_item(__('addworking.enterprise.document_type.create.create')."|active")
@endsection

@section('form')
    {{ $document_type->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document_type.create.create_document')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

