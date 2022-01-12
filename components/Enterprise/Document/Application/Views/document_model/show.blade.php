@extends('foundation::layout.app.show')

@section('title', "{$document->getDocumentTypeModel()->getDisplayName()}")

@section('toolbar')
    @button(__('document::document_model.show.return') ."|href:".route('addworking.enterprise.document.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('document::document_model.show.sign')."|href:".route('enterprise.document.model.sign', [$enterprise, $document])."|icon:signature|color:success|outline|sm|mr:2|class:btn-sm")
@endsection

@section('breadcrumb')
    @include('document::document_model._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <p>{{__('addworking.enterprise.document.show_model.sign_sentence')}}</p>
                        </div>
                        @if($document->files()->exists())
                            @foreach($document->files as $file)
                                {{ $file->views->iframe(['ratio' => "1by1"]) }}
                            @endforeach
                        @else
                            {{ __('addworking.enterprise.document.show_model.no_file') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
