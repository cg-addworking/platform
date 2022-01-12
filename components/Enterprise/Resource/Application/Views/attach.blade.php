@extends('foundation::layout.app.create', ['action' => $resource->routes->attach_post, 'enctype' => "multipart/form-data"])

@section('title', __('enterprise.resource.application.views.attach.title')." {$resource->getNumber()}")

@section('toolbar')
    @button(__('enterprise.resource.application.views.attach.return')."|href:{$resource->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "attach"]) }}
@endsection

@section('form')
    @form_group([
        'type'        => "file",
        'name'        => "file.content",
        'accept'      => 'application/pdf',
        'text'        => __('enterprise.resource.application.views.attach.file'),
    ])

    @button(__('enterprise.resource.application.views.attach.add_file')."|type:submit|color:success|shadow|icon:check")
@endsection
