@inject('contractModelDocumentTypeRepository', 'Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.model.application.views.contract_model_document_type.index.title', ['number' => $contract_model_party->getOrder(), 'denomination' => $contract_model_party->getDenomination()]))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_document_type.index.return')."|href:".route('support.contract.model.show', $contract_model)."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('create', [get_class($contractModelDocumentTypeRepository->make()), $contract_model_party])
        @button(__('components.contract.model.application.views.contract_model_document_type.index.button_create_specific_document')."|href:". route('support.contract.model.party.document_type.create_specific_document', ['contract_model' => $contract_model_party->getContractModel(), 'contract_model_party' => $contract_model_party])."|icon:plus|color:outline-success|outline|sm|mr:2")
        @button(__('components.contract.model.application.views.contract_model_document_type.index.button_create')."|href:". route('support.contract.model.party.document_type.create', [$contract_model_party->getContractModel(), $contract_model_party])."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_document_type._breadcrumb', ['page' => "index"])
@endsection

@section('table.head')
    @include('contract_model::contract_model_document_type._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_model_document_type)
        @include('contract_model::contract_model_document_type._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('components.contract.model.application.views.contract_model_document_type.index.table_row_empty') }}</span>
            @can('create', [get_class($contractModelDocumentTypeRepository->make()), $contract_model_party])
                <div class="mt-4">
                    @button(__('components.contract.model.application.views.contract_model_document_type.index.button_create')."|href:". route('support.contract.model.party.document_type.create', [$contract_model_party->getContractModel(), $contract_model_party])."|icon:plus|color:outline-success|outline|sm|mr:2")
                </div>
            @endcan
        </div>
    @endforelse
@endsection
