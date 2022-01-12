@extends('foundation::layout.app.show')

@section('title', "{$contract_template}")

@section('toolbar')
    @button(__('addworking.contract.contract_template.show.return')."|href:{$contract_template->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_template->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_template->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_template->views->html }}
@endsection
