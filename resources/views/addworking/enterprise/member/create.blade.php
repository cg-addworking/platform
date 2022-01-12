@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.member.store', $enterprise)])

@section('title', __('addworking.enterprise.member.create.refer_user').' : '.strtoupper($enterprise->legal_form) . ' ' . $enterprise->name)

@section('toolbar')
    @button(__('addworking.enterprise.member.create.return')."|href:{$enterprise->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.member.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item(strtoupper($enterprise->legal_form)." {$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.member.create.refer_user')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('users') {{ __('addworking.enterprise.member.create.platform_user') }}</legend>

        @form_group([
            'text'         => __('addworking.enterprise.member.create.users'),
            'type'         => "select",
            'name'         => "member.id",
            'options'      => user()::getAvailableMembersFor($enterprise),
            'required'     => true,
            'selectpicker' => true,
            'search'       => true,
        ])
    </fieldset>

    @include('addworking.enterprise.member._form')

    <div class="text-right my-5">
        @button(__('addworking.enterprise.member.create.record')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
