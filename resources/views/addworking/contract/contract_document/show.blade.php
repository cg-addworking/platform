@extends('foundation::layout.app.show')

@section('title', "{$contract_document}")

@section('toolbar')
    @button(__('addworking.contract.contract_document.show.return')."|href:{$contract_document->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_document->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_document->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_document->views->html }}
@endsection
