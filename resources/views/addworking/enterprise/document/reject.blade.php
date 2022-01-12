@extends('foundation::layout.app.edit', ['action' => $document->routes->store_reject, 'method' => "patch"])

@section('title', __('addworking.enterprise.document.reject.decline_document')." {$document->documentType->display_name} de {$enterprise->name}");

@section('toolbar')
    @button(__('addworking.enterprise.document.reject.return')."|href:{$document->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.reject.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.reject.company')."|href:{$document->enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$document->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.reject.document')."|href:{$document->routes->index}")
    @breadcrumb_item("{$document->documentType->display_name} de {$document->enterprise->name}|href:{$document->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.reject.refuse')."|active")
@endsection

@section('form')
    {{ $document->views->form_reject }}

    <input type="hidden" name="comment[commentable_id]" value="{{ $document->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($document)) }}">
    <input type="hidden" name="comment[visibility]" value="{{ comment()::VISIBILITY_PUBLIC }}">

    @form_group([
        'text'     => __('addworking.enterprise.document.reject.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'rows'     => 10,
        'id'       => "textarea-comment",
    ])

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document.reject.refuse')."|type:submit|color:danger|shadow|icon:times")
    </div>
@endsection
