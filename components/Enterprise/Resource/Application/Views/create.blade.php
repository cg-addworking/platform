@extends('foundation::layout.app.create', ['action' => $resource->routes->store, 'enctype' => "multipart/form-data"])

@section('title', __('enterprise.resource.application.views.create.title')." {$resource->enterprise->name}")

@section('toolbar')
    @button(__('enterprise.resource.application.views.create.return')."|href:".route('addworking.enterprise.resource.index', $resource->enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $resource->views->form }}

    @button(__('enterprise.resource.application.views.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
