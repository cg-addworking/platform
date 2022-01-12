@extends('addworking.enterprise.enterprise.create', ['action' => route('subsidiaries.store', $enterprise), 'enterprise' => $subsidiary])

@section('title', __('addworking.enterprise.enterprise_subsidiaries.create.create_subsidiary')." {$enterprise->name}");

@section('toolbar')
    @button(__('addworking.enterprise.enterprise_subsidiaries.create.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise_subsidiaries.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.route('enterprise.index') )
    @breadcrumb_item(__('addworking.enterprise.enterprise_subsidiaries.create.subsidiaries').'|href:'.route('subsidiaries.index', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.enterprise_subsidiaries.create.create')."|active")
@endsection
