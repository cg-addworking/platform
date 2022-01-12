@inject('contractModelPartRepository', 'Components\Contract\Model\Application\Repositories\ContractModelPartRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.model.application.views.contract_model_part.index.title'))

@section('toolbar')
    @can('index', get_class($contractModelPartRepository->make()))
        @button(__('addworking.contract.contract.create_blank.return')."|href:" . route('support.contract.model.show',$contract_model)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @endcan
    @can('create', [get_class($contractModelPartRepository->make()), $contract_model])
        @button(__('components.contract.model.application.views.contract_model_part.index.button_create')."|href:". route('support.contract.model.part.create', $contract_model)."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_part._breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="25%">
    <col width="25%">
    <col width="25%">
    <col width="20%">
@endsection

@section('table.head')
    @include('contract_model::contract_model_part._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_model_part)
        @include('contract_model::contract_model_part._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('components.contract.model.application.views.contract_model_part.index.table_row_empty') }}</span>
            @can('create', [get_class($contractModelPartRepository->make()), $contract_model])
                <div class="mt-4">
                    @button(__('components.contract.model.application.views.contract_model_part.index.button_create')."|href:". route('support.contract.model.part.create', $contract_model)."|icon:plus|color:outline-success|outline|sm|mr:2")
                </div>
            @endcan
        </div>
    @endforelse
@endsection
