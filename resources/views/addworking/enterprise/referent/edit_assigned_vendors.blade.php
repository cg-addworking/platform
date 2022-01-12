@extends('foundation::layout.app.edit', ['action' => route('addworking.enterprise.referent.assigned_vendor.update', compact('enterprise', 'user')), 'method' => 'POST'])

@section('title', $user->name)

@section('toolbar')
    @button(__('addworking.enterprise.referent.edit_assigned_vendors.return')."|icon:arrow-left|color:secondary|outline|sm|href:".route('addworking.enterprise.member.index', compact('enterprise')))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.referent.edit_assigned_vendors.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.referent.edit_assigned_vendors.company_members')."|href:".route('addworking.enterprise.member.index', compact('enterprise')))
    @breadcrumb_item("{$user->name}|href:".route('addworking.enterprise.member.show', compact('user', 'enterprise')))
    @breadcrumb_item(__('addworking.enterprise.referent.edit_assigned_vendors.modify_assigned_providers')."|active")
@endsection

@section('form')

    @include('addworking.enterprise.referent._form_assigned_vendors', compact('user', 'enterprise'))

    <div class="text-right my-5">
        @button(__('addworking.enterprise.referent.edit_assigned_vendors.record')."|type:submit|color:success|shadow|icon:save")
    </div>

    <div class="col-md-6">
        <legend class="text-primary h5">@icon('user-friends') {{ __('addworking.enterprise.referent.edit_assigned_vendors.assigned_providers_list') }}</legend>
        <ul>
            @forelse ($user->referentVendorsOf($enterprise)->get() as $vendor)
                <li>{{ $vendor->views->link }} : {{ __('addworking.enterprise.referent.edit_assigned_vendors.assigned_by') }} <strong>{{ user($vendor->pivot->created_by)->name }}</strong></li>
            @empty
                <li>@lang('messages.empty')</li>
            @endforelse
        </ul>
    </div>

@endsection
