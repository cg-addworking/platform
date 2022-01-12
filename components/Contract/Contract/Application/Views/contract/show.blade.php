@inject('contractPartyRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartyRepository')
@inject('contractVariableRepository', 'Components\Contract\Contract\Application\Repositories\ContractVariableRepository')
@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('contractPartRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartRepository')

@extends('foundation::layout.app.show')

@section('title', $contract->getName())

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.show.return')."|href:".route('contract.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('sign', $contract)
        @button(__('components.contract.contract.application.views.contract.show.sign')."|href:".route('contract.sign', [$contract, $logged_in_party])."|icon:signature|color:success|outline|sm|mr:2")
    @endcan

    @can('validate', [$contract, $logged_in_validator])
        @button(__('components.contract.contract.application.views.contract.show.validate')."|href:".route('contract.validate', [$contract, $logged_in_validator])."|icon:signature|color:success|outline|sm|mr:2")
    @endcan

    @can('edit', [get_class($contractVariableRepository->make()), $contract])
        @if ($contractVariableRepository->getUserFillableContractVariable($contract, $user, null, true)->count())
           @button(__('components.contract.contract.application.views.contract.show.edit_variable')."|href:".route('contract.variable.define_value', $contract)."|icon:edit|color:success|outline|sm|mr:2")
        @endif
    @endcan

    @can('sendToSign', $contract)
        @button(__('components.contract.contract.application.views.contract.show.send_to_sign')."|href:".route('contract.send_to_sign', $contract)."|icon:file-signature|color:success|outline|sm|mr:2")
    @endcan

    @can('sendToManager', $contract)
        @button(__('components.contract.contract.application.views.contract.show.send_to_manager')."|href:".route('contract.send_to_manager', $contract)."|icon:paper-plane|color:success|outline|sm|mr:2")
    @endcan

    @can('requestValidationAndSendToSign', $contract)
        @button(__('components.contract.contract.application.views.contract.show.request_validation')."|href:".route('contract.send_to_sign', $contract)."|icon:plus|color:success|outline|sm|mr:2")
    @endcan

    @can('requestValidation', $contract)
        @button(__('components.contract.contract.application.views.contract.show.request_validation')."|href:".route('contract.request_validation', $contract)."|icon:plus|color:success|outline|sm|mr:2")
    @endcan

    @can('requestSignature', $contract)
        @button(__('components.contract.contract.application.views.contract.show.request_signature', ['designation_pp' => $contractPartyRepository->getNextPartyThatShouldSign($contract)->getDenomination()])."|href:".route('contract.request_signature', $contract)."|icon:plus|color:success|outline|sm|mr:2")
    @endcan

    @can('uploadDocumentsNBA', $logged_in_party)
        @button(__('components.contract.contract.application.views.contract.show.upload_documents')."|href:".route('contract.party.document.index', [$contract, $logged_in_party])."|icon:edit|color:primary|outline|sm|mr:2")
    @endcan
    @if($user->can('create', [get_class($contractPartRepository->make()), $contract]) ||
        $user->can('createSignedContractPart', [get_class($contractPartRepository->make()), $contract]) ||
        $user->can('createAmendment', $contract) || $user->can('createAmendmentWithoutModelToSign',$contract) ||
        $user->can('createAmendmentWithoutModel',$contract))
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle mr-2" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('components.contract.contract.application.views.contract.show.add_dropdown') }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
                @can('create', [get_class($contractPartRepository->make()), $contract])
                    <a class="dropdown-item" href="{{ route('contract.part.create', $contract) }}">
                        @icon('plus|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract.show.add_part') }}
                    </a>
                @endcan

                @can('createSignedContractPart', [get_class($contractPartRepository->make()), $contract])
                    <a class="dropdown-item" href="{{ route('contract.part.create.signed.contract.part', $contract) }}">
                        @icon('plus|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract.show.add_part_to_signed_contract') }}
                    </a>
                @endcan

                @can('createAmendment', $contract)
                    <a class="dropdown-item" href="{{ route('contract.amendment.create', $contract) }}">
                        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract.show.create_amendment') }}
                    </a>
                @endcan

                @can('createAmendmentWithoutModelToSign', $contract)
                    <a class="dropdown-item" href="{{ route('contract.create_amendment_without_model_to_sign', $contract) }}">
                        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract.show.create_amendment_without_model_to_sign') }}
                    </a>
                @endcan

                @can('createAmendmentWithoutModel', $contract)
                    <a class="dropdown-item" href="{{ route('contract.create_amendment_without_model', $contract) }}">
                        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract.show.create_amendment_without_model') }}
                    </a>
                @endcan
            </div>
        </div>
    @endif

    @component('foundation::layout.app._actions')
        @include('contract::contract._actions')
    @endcomponent

@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @if($contract->getState() == 'active' && !$contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract))
        <div class="alert alert-warning" role="alert">
            Vous avez des documents non conformes liés à ce contrat.
        </div>
    @endif

    @include('contract::contract._html')
@endsection
