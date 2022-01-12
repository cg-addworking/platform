@inject('documentRepository', "App\Repositories\Addworking\Enterprise\DocumentRepository")

@extends('foundation::layout.app.show')

@if($document->documentType->exists)
    @section('title', "{$document->documentType->display_name}")
@else
    @section('title', "{$document->contractModelPartyDocumentType->display_name}")
@endif

@section('toolbar')
    @button(__('addworking.enterprise.document.show.return')."|href:{$document->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2|class:btn-sm")

    @if(! $documentRepository->isPreCheck($document))
        @can('preCheck', $document)
            <a class="btn btn-sm btn-outline-primary mr-2" href="{{ route('addworking.enterprise.document.show_pre_check', [$enterprise, $document]) }}">
                @icon("check-double") {{ __('addworking.enterprise.document.show.pre_validate') }}
            </a>
        @endcan
    @else
        @can('noPreCheck', $document)
            <a class="btn btn-sm btn-primary mr-2" href="{{ route('addworking.enterprise.document.show_no_pre_check', [$enterprise, $document]) }}">
                @icon("check-double")
            </a>
        @endcan
    @endif

    @can('showHistory', $document)
        <a href="{{ route('addworking.enterprise.document.history', [$enterprise, $document->getDocumentType()])}}" class="btn btn-outline-warning btn-sm mr-2"><i class="fa fa-history"></i></a>
    @endcan

    @can('accept', $document)
        @button(__('addworking.enterprise.document.show.accept')."|href:{$document->routes->accept}|icon:check|color:success|outline|mr:2|class:btn-sm")
    @endcan

    @if($document->isValidated())
        <button class="btn btn-sm btn-success mr-2" disabled>
            @icon("check")
        </button>
    @endif

    @can('reject', $document)
        @button(__('addworking.enterprise.document.show.refuse')."|href:{$document->routes->reject}|icon:times|color:danger|outline|mr:2|class:btn-sm")
    @endcan

    @if($document->isRejected())
        <button class="btn btn-sm btn-danger mr-2" disabled>
            @icon("times")
        </button>
    @endif

    @can('sign', $document)
        @if ($document->getDocumentTypeModel()->getRequiresDocuments())
            @if (is_null($document->getRequiredDocument()))
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{__('addworking.enterprise.document.show_model.add_documents')}}">
                    <button  href="{{route('enterprise.document.model.sign', [$enterprise, $document])}}" type="button" class="btn btn-sm mr-2 btn-outline-success" disabled><i class="fa fa-signature"> {{__('addworking.enterprise.document.show_model.sign')}}</i></button>
                </span>
            @else
                @button(__('addworking.enterprise.document.show_model.sign')."|href:".route('enterprise.document.model.sign', [$enterprise, $document])."|icon:signature|color:success|outline|sm|mr:2|class:btn-sm")
            @endif
        @else
            @button(__('addworking.enterprise.document.show_model.sign')."|href:".route('enterprise.document.model.sign', [$enterprise, $document])."|icon:signature|color:success|outline|sm|mr:2|class:btn-sm")
        @endif
    @endcan

    @can('addRequiredDocument', $document)
        @button(__('document::document_model.show.add_required_document')."|href:".route('enterprise.document.model.add_required_document', [$enterprise, $document])."|icon:plus|color:success|outline|sm|mr:2|class:btn-sm")
    @endcan

    {{ $document->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.show.company').'|href:'.$document->enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$document->enterprise->routes->show )
    @breadcrumb_item(__('addworking.enterprise.document.show.document').'|href:'.$document->routes->index )
    @breadcrumb_item($document->documentType->display_name ?? $document->contractModelPartyDocumentType->display_name."|active")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if($document->files()->exists())
                        @foreach($document->files as $file)
                            {{ $file->views->iframe(['ratio' => "1by1"]) }}
                        @endforeach
                    @else
                        {{ __('addworking.enterprise.document.show.no_file') }}
                    @endif
                        <br>
                        @if($document->getRequiredDocument() && is_null($document->signed_at))
                            {{ $document->getRequiredDocument()->views->iframe(['ratio' => "1by1"]) }}
                        @endif
                </div>
            </div>
            @if (! is_null($document->getProofAuthenticity())
                && ( is_null($document->getDocumentType())
                    || (
                            !is_null($document->getDocumentType()) &&
                            ( \Illuminate\Support\Facades\Auth::User()->isSupport() ||
                            $document->getDocumentType()->name !==  App\Models\Addworking\Enterprise\DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_ESTABLISHMENT
                            )
                        )
                    )
                )
                <div class="card shadow mt-2">
                    <div class="card-header">
                        <h5 class="mb-0">
                            {{ __('addworking.enterprise.document.show.proof_authenticity') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        {{ $document->getProofAuthenticity()->views->iframe(['ratio' => '1by1']) }}
                    </div>
                </div>
            @endif
            @support
            <div class="card shadow mt-2">
                <button class="btn btn-outline mt-2" type="button" data-toggle="collapse" data-target="#collapseMoreInfo" aria-expanded="false" aria-controls="collapseMoreInfo">
                    <h6 class="card-title">@icon('caret-down') {{ __('addworking.enterprise.document._html.further_information') }}</h6>
                </button>
                <div class="collapse" id="collapseMoreInfo">
                    <div class="card-body">
                        @component('bootstrap::attribute', ['icon' => "info", 'label' => __('addworking.enterprise.document._html.status')])
                            {{ $document->views->status }}
                        @endcomponent

                        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document._html.type')])
                            {{ $document->documentType->views->summary}}
                        @endcomponent

                        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document._html.code')])
                            {{ $document->documentType->code ?? 'n/a' }}
                        @endcomponent

                        @component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('addworking.enterprise.document._html.validity_period')])
                            {{ $document->documentType->validity_period ?? 'n/a' }} {{ __('addworking.enterprise.document._html.days') }}
                        @endcomponent

                        @component('bootstrap::attribute', ['icon' => "key", 'label' => __('addworking.enterprise.document._html.username')])
                            {{ $document->id ?? 'n/a' }}
                        @endcomponent

                        @component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('addworking.enterprise.document._html.modified')])
                            @date($document->updated_at)
                        @endcomponent

                        @if ($document->trashed())
                            @component('bootstrap::attribute', ['icon' => "trash", 'color' => "danger", 'label' => __('addworking.enterprise.document._html.delete_it')])
                                @date($document->deleted_at)
                            @endcomponent
                        @endif
                    </div>
                </div>
            </div>
            @endsupport
        </div>
        <div class="col-md-4">
            {{ $document->views->html }}
        </div>
    </div>
@endsection
