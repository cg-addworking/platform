@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('contractModelRepository', 'Components\Contract\Model\Application\Repositories\ContractModelRepository')
@inject('annexRepository', 'Components\Contract\Contract\Application\Repositories\AnnexRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.contract.application.views.contract.index.title'))

@section('toolbar')
    @can('create', get_class($contractRepository->make()))
        @button(__('components.contract.contract.application.views.contract.index.create')."|href:".route('support.contract.create')."|icon:list-alt|color:success|outline|sm|mr:2")
    @endcan
    <div class="dropdown">
        <button class="btn btn-outline-success btn-sm dropdown-toggle mr-2" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('components.contract.contract.application.views.contract.index.create_dropdown') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
            @can('createContractWithoutModelToSign', get_class($contractRepository->make()))
                <a class="dropdown-item" href={{route('contract.create_contract_without_model_to_sign')}}> {{__('components.contract.contract.application.views.contract.index.create_contract_without_model_to_sign')}} </a>
            @endcan
            @can('createContractWithoutModel', get_class($contractRepository->make()))
                <a class="dropdown-item" href={{route('contract.create_contract_without_model')}}> {{__('components.contract.contract.application.views.contract.index.create_contract_without_model') }}</a>
            @endcan
        </div>
    </div>
    @can('index',get_class($contractModelRepository->make()))
        @button(__('components.contract.contract.application.views.contract.index.contract_model')."|href:".route('support.contract.model.index')."|icon:list-alt|color:primary|outline|sm|mr:2")
    @endcan

    @can('indexSupport',get_class($annexRepository->make()))
        @button(__('components.contract.contract.application.views.contract.index.annex')."|href:".route('support.annex.index')."|icon:book-open|color:primary|outline|sm|mr:2")
    @endcan

    @can('export', get_class($contractRepository->make()))
        @button(__('components.contract.contract.application.views.contract.index.export')."|href:".route('contract.export')."?".Request()->getQueryString()."|icon:list-alt|color:primary|outline|sm|mr:2")
    @endcan

    @button(__('components.contract.contract.application.views.contract.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
     @include('contract::contract._breadcrumb')
@endsection

@section('form')
    @include('contract::contract.support._filters')
@endsection

@section('table.head')
    @include('contract::contract._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $contract)
        @include('contract::contract._table_row')
    @endforeach
@endsection
