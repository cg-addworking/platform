@extends('foundation::layout.app.edit', ['action' => $resource->routes->update])

@section('title', __('enterprise.resource.application.views.edit.title')." {$resource->getNumber()}")

@section('toolbar')
    @button(__('enterprise.resource.application.views.edit.return')."|href:{$resource->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $resource->views->form }}

    @button(__('enterprise.resource.application.views.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
