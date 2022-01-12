@extends('foundation::layout.app.show')

@section('title', "{$contract_annex}")

@section('toolbar')
    @button(__('addworking.contract.contract_annex.show.return')."|href:{$contract_annex->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_annex->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_annex->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_annex->views->html }}
@endsection
