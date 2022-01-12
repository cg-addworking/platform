@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.member.update', compact('enterprise', 'user')), 'enctype' => 'multipart/form-data', 'method' => 'POST'])

@section('title', $user->name)

@section('toolbar')
    @button(__('addworking.enterprise.member.edit.return')."|icon:arrow-left|color:secondary|outline|sm|href:".route('addworking.enterprise.member.index', compact('enterprise')))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.member.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.member.edit.company_members')."|href:".route('addworking.enterprise.member.index', compact('enterprise')))
    @breadcrumb_item("{$user->name}|href:".route('addworking.enterprise.member.show', compact('user', 'enterprise')))
    @breadcrumb_item(__('addworking.enterprise.member.edit.edit')."|active")
@endsection

@section('form')

    @include('addworking.enterprise.member._form', compact('user'))

    <div class="text-right my-5">
        @button(__('addworking.enterprise.member.edit.record')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
