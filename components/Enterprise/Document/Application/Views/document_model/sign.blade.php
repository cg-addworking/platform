@extends('foundation::layout.app.show')

@section('title', "{$document->getDocumenttype()->getDisplayName()}")

@section('toolbar')
    @button(__('document::document_model.sign.return') ."|href:".route('addworking.enterprise.document.show', [$enterprise, $document])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('document::document_model._breadcrumb', ['page' => "sign"])
@endsection

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="{{ $sign_frame_ui }}"></iframe>
            </div>
        </div>
    </div>
@endsection
