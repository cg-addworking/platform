@extends('foundation::layout.app.edit', ['action' => $document->routes->store_accept, 'method' => "patch"])

@section('title', __('addworking.enterprise.document.accept.accept_document')." {$document->documentType->display_name} de {$enterprise->name}");

@section('toolbar')
    @button(__('addworking.enterprise.document.accept.return')."|href:{$document->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.accept.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.accept.company') ."|href:{$document->enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$document->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.accept.document') ."|href:{$document->routes->index}")
    @breadcrumb_item("{$document->documentType->display_name} de {$document->enterprise->name}|href:{$document->routes->show}" )
    @breadcrumb_item(__('addworking.enterprise.document.accept.accept') ."|active")
@endsection

@section('form')
    {{ $document->views->form_accept }}

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document.accept.accept') ."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
