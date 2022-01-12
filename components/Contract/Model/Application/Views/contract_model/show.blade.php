@inject('contractModelPartRepository', 'Components\Contract\Model\Application\Repositories\ContractModelPartRepository')
@inject('contractModelVariableRepository', 'Components\Contract\Model\Application\Repositories\ContractModelVariableRepository')
@inject('contractModelRepository', 'Components\Contract\Model\Application\Repositories\ContractModelRepository')

@extends('foundation::layout.app.show')

@section('title', "{$contract_model->display_name}")

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model.show.back')."|href:".route('support.contract.model.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('publish', $contract_model)
        <a class="text-center btn btn-sm btn-outline-success mr-2" href="#" onclick="confirm('Confirmer la publication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('eye') {{ __('components.contract.model.application.views.contract_model.show.publish_button') }}
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.publish', $contract_model) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan

    @can('create', [get_class($contractModelPartRepository->make()), $contract_model])
        @button(__('components.contract.model.application.views.contract_model.show.part')."|href:". route('support.contract.model.part.create', $contract_model)."|icon:file-contract|color:outline-success|outline|sm|mr:2")
    @endcan

    @can('edit', [get_class($contractModelVariableRepository->make()), $contract_model])
        @button(__('components.contract.model.application.views.contract_model.show.variable')."|href:".route('support.contract.model.variable.edit', $contract_model)."|icon:asterisk|color:primary|outline|sm|mr:2")
    @endcan

    @can('unpublish', [get_class($contractModelRepository->make()), $contract_model])
        <a class="text-center btn btn-sm btn-outline-danger mr-2" href="#" onclick="confirm('Confirmer la dépublication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('undo') {{ __('components.contract.model.application.views.contract_model.show.unpublished_button') }}
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.unpublish', $contract_model) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan

    @include('contract_model::contract_model._actions')
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @if (! count($contract_model->getParts()))
        @include('contract_model::contract_model._html')
    @else
        @include('contract_model::contract_model._html_part')
    @endif
@endsection
