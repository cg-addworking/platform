@extends('foundation::layout.app.show')

@section('title', $type->display_name)

@section('toolbar')
    @button("Retour|href:".route('addworking.enterprise.document-type.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|ml:2|mr:2")

    <button type="button" class="btn btn-sm btn-outline-info mr-2" data-toggle="modal" data-target="#store-document-type-model-{{ $type->id}}">
        <i class="fa fa-edit"></i> {{ __('addworking.enterprise.document_type.show.add_modify_template') }}
    </button>

    <button type="button" class="btn btn-sm btn-outline-info mr-2" data-toggle="modal" data-target="#create-document-type-field-{{ $type->id }}">
        <i class="fa fa-plus"></i> {{ __('addworking.enterprise.document_type.show.add_field') }}
    </button>

    {{ $type->views->actions }}


@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document_type.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document_type.show.company').'|href:'.$enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item(__('addworking.enterprise.document_type.show.document_type_management').'|href:'.$type->routes->index )
    @breadcrumb_item($type->display_name.'|href:'.$type->routes->show )
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.enterprise.document_type.show.general_information') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">

        {{ $type->views->html }}

    </div>

    @include('addworking.enterprise.document_type._add_model')
    @include('addworking.enterprise.document_type_field._create')

@endsection
