@extends('foundation::layout.app.create', ['action' => $type->routes->update, 'enctype' => 'multipart/form-data', 'method' => 'PUT'])

@section('title', __('addworking.enterprise.document_type.edit.edit_document'))

@section('toolbar')
    @button(__('addworking.enterprise.document_type.edit.return')."|href:{$type->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document_type.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document_type.edit.company').'|href:'.$enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item(__('addworking.enterprise.document_type.edit.document_type_management').'|href:'.$type->routes->index )
    @breadcrumb_item($type->display_name.'|href:'.$type->routes->show )
    @breadcrumb_item(__('addworking.enterprise.document_type.edit.edit')."|active")
@endsection

@section('form')

    {{ $type->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document_type.edit.edit_document')."|type:submit|color:primary|shadow|icon:check")
    </div>
@endsection
