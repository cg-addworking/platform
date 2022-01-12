@extends('foundation::layout.app.create', ['action' => $contract->routes->createFromTemplatePost])

@section('title', __('addworking.contract.contract.create_from_template.create_contract'))

@section('toolbar')
    @button(__('addworking.contract.contract.create_from_template.return')."|href:{$contract->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    @form_group([
        'type'     => "select",
        'name'     => "template",
        'options'  => $templates->pluck('name', 'id'),
        'required' => true,
    ])

    @button(__('addworking.contract.contract.create_from_template.create')."|icon:save|type:submit")
@endsection
