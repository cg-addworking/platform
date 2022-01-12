@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.member.invitation.store', compact('enterprise'))])

@section('title', __('addworking.enterprise.member.invitation.create.invite_member'))

@section('toolbar')
    @button(__('addworking.enterprise.member.invitation.create.return')."|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.member.invitation.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.member.invitation.create.my_invitations')."|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
    @breadcrumb_item(__('addworking.enterprise.member.invitation.create.invite_member')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('envelope') {{ __('addworking.enterprise.member.invitation.create.user_invite') }}</legend>

        @form_group([
            'text'         => 'Email',
            'type'         => 'text',
            'name'         => 'email',
            'required'     => true,
        ])
    </fieldset>

    @include('addworking.enterprise.member._form')

    <div class="text-right my-5">
        @button(__('addworking.enterprise.member.invitation.create.invite')."|type:submit|color:success|shadow|icon:paper-plane")
    </div>
@endsection

