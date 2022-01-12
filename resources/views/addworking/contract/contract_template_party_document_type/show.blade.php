@extends('foundation::layout.app.show')

@section('title', "{$contract_template_party_document_type}")

@section('toolbar')
    @button(__('addworking.contract.contract_template_party_document_type.show.return')."|href:{$contract_template_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_template_party_document_type->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_template_party_document_type->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_template_party_document_type->views->html }}
@endsection
