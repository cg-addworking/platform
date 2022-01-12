@extends('foundation::layout.app.edit', ['action' => $document->routes->update])

@section('title', "{$document->documentType->display_name} de {$enterprise->name}");

@section('toolbar')
    @button(__('addworking.enterprise.document.edit.return')."|href:{$document->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.edit.company')."|href:{$document->enterprise->routes->index}")
    @breadcrumb_item("{$enterprise}|href:{$document->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.edit.document')."|href:{$document->routes->index}")
    @breadcrumb_item("{$document->documentType} de {$document->enterprise}|href:{$document->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.edit.modify')."|".__('addworking.enterprise.document.edit.active'))
@endsection

@section('form')
    {{ $document->views->form }}
    {{ $document->views->form_fields }}

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document.edit.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
