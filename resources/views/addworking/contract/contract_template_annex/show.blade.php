@extends('foundation::layout.app.show')

@section('title', "{$contract_template_annex}")

@section('toolbar')
    @button(__('addworking.contract.contract_template_annex.show.return')."|href:{$contract_template_annex->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_template_annex->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_template_annex->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_template_annex->views->html }}
@endsection
