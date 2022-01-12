@extends('addworking.enterprise.enterprise.index')

@section('title', __('addworking.enterprise.enterprise_subsidiaries.index.subsidiaries_of')." {$enterprise->name}")

@section('toolbar')
    @button(__('addworking.enterprise.enterprise_subsidiaries.index.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.enterprise.enterprise_subsidiaries.index.create_subsidiary')."|href:".route('subsidiaries.create', ['enterprise' => $enterprise])."|icon:plus|color:success|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise_subsidiaries.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.enterprise_subsidiaries.index.subsidiaries')."|active")
@endsection
