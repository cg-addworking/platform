@inject('contractVariableRepository', 'Components\Contract\Contract\Application\Repositories\ContractVariableRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.contract.application.views.contract_variable.index.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract_variable.index.return')."|href:".route('contract.show', $contract)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('edit', [get_class($contractVariableRepository->make()), $contract])
        @button(__('components.contract.contract.application.views.contract_variable.index.define_value')."|href:".route('contract.variable.define_value', $contract)."|icon:edit|color:primary|outline|sm|mr:2")
        @button(__('components.contract.contract.application.views.contract_variable.index.refresh')."|href:".route('contract.variable.refresh', $contract)."|icon:edit|color:primary|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('contract::contract_variable._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('contract::contract_variable._filters')
@endsection

@section('table.colgroup')
    <col width="15%">
    <col width="20%">
    <col width="15%">
    <col width="30%">
    <col width="5%">
    <col width="40%">
@endsection

@section('table.head')
    @include('contract::contract_variable._table_head')
@endsection

@section('table.body')
    @forelse ($items as $contract_variable)
        @include('contract::contract_variable._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('components.contract.contract.application.views.contract_variable.index.table_row_empty') }}</span>
        </div>
    @endforelse
@endsection
