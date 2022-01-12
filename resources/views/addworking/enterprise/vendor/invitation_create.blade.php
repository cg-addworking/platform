@extends('addworking.enterprise.invitation.create', ['action' => route('addworking.enterprise.vendor.invitation_store', compact('enterprise'))])

@section('title', __('addworking.enterprise.vendor.invitation_create.invite_provider_join_client'))

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation_create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation_create.my_invitations')."|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
    @breadcrumb_item(__('addworking.enterprise.vendor.invitation_create.invite_provider')."|active")
@endsection
