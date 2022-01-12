@inject('userRepository', 'Components\Contract\Contract\Application\Repositories\UserRepository')

@extends('foundation::layout.app.edit', ['action' => "#"])

@section('title', __('components.contract.contract.application.views.contract_variable.define_value.title'))

@section('toolbar')
    @if($userRepository->isSupport($user))
        <a role="button" href="#" id='request-variable-value-display-button' class="btn btn-outline-success btn-sm mr-2">
            <i class="fas fa-fw fa-hand-pointer"></i>
            {{__('components.contract.contract.application.views.contract_variable.define_value.request_value_button')}}
        </a>
    @endif
    <a role="button" href="#" onclick="confirm('{{__('components.contract.contract.application.views.contract_variable.index.refresh_warning')}}') && window.location.replace('{{route('contract.part.regenerate', $contract)}}')" class="btn btn-outline-success btn-sm mr-2">
        <i class="fas fa-fw fa-redo"></i>
        {{__('components.contract.contract.application.views.contract_variable.index.regenerate')}}
    </a>
    <a role="button" href="#" onclick="confirm('{{__('components.contract.contract.application.views.contract_variable.index.refresh_warning')}}') && window.location.replace('{{route('contract.variable.refresh', $contract)}}')" class="btn btn-outline-primary btn-sm mr-2">
        <i class="fas fa-fw fa-edit"></i>
        {{__('components.contract.contract.application.views.contract_variable.index.refresh')}}
    </a>
    @button(__('components.contract.contract.application.views.contract_variable.define_value.return')."|href:".route('contract.variable.index', $contract)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract_variable._breadcrumb', ['page' => 'edit'])
@endsection

@section('form')

    <h2>{{$contract->getName()}}</h2>
    @include('contract::contract_variable._form')

    @if(! empty($variables_by_parts))
        <a role="button" href="#" onclick="confirm('{{__('components.contract.contract.application.views.contract_variable.index.refresh_warning')}}') && window.location.replace('{{route('contract.part.regenerate', $contract)}}')" class="btn btn-outline-success btn-sm offset-md-8 col-md-2 mt-3">
            <i class="fas fa-fw fa-redo"></i>
            {{__('components.contract.contract.application.views.contract_variable.index.regenerate')}}
        </a>
    @endif
@endsection
