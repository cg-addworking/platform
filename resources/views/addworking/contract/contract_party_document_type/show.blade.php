@extends('foundation::layout.app.show')

@section('title', "{$contract_party_document_type}")

@section('toolbar')
    @button(__('addworking.contract.contract_party_document_type.show.return')."|href:{$contract_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_party_document_type->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_party_document_type->views->html }}
@endsection
