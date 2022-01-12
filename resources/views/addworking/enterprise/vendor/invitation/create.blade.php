@extends('layout.app.create', ['action' => route('addworking.enterprise.vendor.invitation.store', compact('enterprise'))])

@section('title', __('addworking.enterprise.vendor.invitation.create.provider_invitation'))

@section('toolbar')
    @button(__('addworking.enterprise.vendor.invitation.create.return')."|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation.create.my_invitations')."|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation.create.provider_invitation')."|active")
@endsection

@section('form')
    <div class="card text-white bg-info">
        <h5 class="card-header">{{ __('addworking.enterprise.vendor.invitation.create.service_provider_information') }}</h5>
        <div class="card-body">
            {{ __('addworking.enterprise.vendor.invitation.create.invite_several_providers_once') }} :
            <div class="card-body">
                {{ __('addworking.enterprise.vendor.invitation.create.provider1') }}<br>
                {{ __('addworking.enterprise.vendor.invitation.create.provider2') }}<br>
                {{ __('addworking.enterprise.vendor.invitation.create.provider3') }}<br>
                {{ __('addworking.enterprise.vendor.invitation.create.provider4') }}<br>
                {{ __('addworking.enterprise.vendor.invitation.create.provider5') }}<br>
            </div>
        </div>
    </div>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('envelope') {{ __('addworking.enterprise.vendor.invitation.create.user_invite') }}</legend>

        @form_group([
            'text'         => 'Emails',
            'type'         => 'textarea',
            'name'         => 'emails',
            'required'     => true,
            'value'        => session('_old_input.emails') ?? null,
            'rows'         => 15
        ])
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.vendor.invitation.create.invite')."|type:submit|color:success|shadow|icon:paper-plane")
    </div>
@endsection