@inject('contractModelVariableRepository', 'Components\Contract\Model\Application\Repositories\ContractModelVariableRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.model.application.views.contract_model_variable.index.title'))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_variable.index.return')."|href:" . route('support.contract.model.show',$contract_model)."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('edit', [get_class($contractModelVariableRepository->make()), $contract_model])
        @button(__('components.contract.model.application.views.contract_model_variable.index.edit')."|href:".route('support.contract.model.variable.edit', $contract_model)."|icon:edit|color:primary|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_variable._breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="15%">
    <col width="15%">
    <col width="15%">
    <col width="10%">
    <col width="25%">
    <col width="10%">
    <col width="5%">
    <col width="5%">
@endsection

@section('table.head')
    @include('contract_model::contract_model_variable._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @if(!empty($items))
                @foreach($contract_model->getParts()->sortBy('created_at') as $contract_model_part)
                    @foreach($items as $contract_model_variable)
                        @if($contract_model_variable->getContractModelPart()->getId() === $contract_model_part->getId())
                            @include('contract_model::contract_model_variable._table_row', compact('items'))
                        @endif
                    @endforeach
                @endforeach

    @else
        <div class="text-center mb-3">
            <span>{{ __('components.contract.model.application.views.contract_model_variable.index.table_row_empty') }}</span>
        </div>
    @endif
@endsection
