@inject('contractModelRepository', 'Components\Contract\Model\Application\Repositories\ContractModelRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.model.application.views.contract_model.index.title'))

@section('toolbar')
    @can('create', get_class($contractModelRepository->make()))
        @button(__('components.contract.model.application.views.contract_model.index.button_create')."|href:". route('support.contract.model.create')."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('contract_model::contract_model._filters')
@endsection

@section('table.colgroup')
    <col width="10%">
    <col width="15%">
    <col width="35%">
    <col width="35%">
    <col width="5%">
@endsection

@section('table.head')
    @include('contract_model::contract_model._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_model)
        @include('contract_model::contract_model._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('components.contract.model.application.views.contract_model.index.table_row_empty') }}</span>
            @can('create', get_class($contractModelRepository->make()))
                <div class="mt-4">
                    @button(__('components.contract.model.application.views.contract_model.index.button_create')."|href:". route('support.contract.model.create')."|icon:plus|color:outline-success|outline|sm|mr:2")
                </div>
            @endcan
        </div>
    @endforelse
@endsection
