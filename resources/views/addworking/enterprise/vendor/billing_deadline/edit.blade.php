@extends('layout.app.edit', ['action' => route('addworking.enterprise.vendor.billing_deadline.update', @compact('enterprise', 'vendor'))])

@section('title', __('addworking.enterprise.vendor.billing_deadline.edit.payment_terms')." {$vendor->name}")

@section('toolbar')
    @button(__('addworking.enterprise.vendor.billing_deadline.edit.return')."|href:".route('addworking.enterprise.vendor.billing_deadline.index', @compact('enterprise', 'vendor'))."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.edit.dashboard').'|href:'.route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.edit.my_providers')."|href:".route('addworking.enterprise.vendor.index', $enterprise))
    @breadcrumb_item("{$vendor->name}|href:{$vendor->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.edit.payment_deadline')."|href:".route('addworking.enterprise.vendor.billing_deadline.index', @compact('enterprise', 'vendor')))
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.edit.setting')."|active")
@endsection

@section('form')
    <div class="mb-4">
        @form_group([
            'text'        => __('addworking.enterprise.vendor.billing_deadline.edit.payment_deadline'),
            'type'        => "checkbox_list",
            'name'        => "deadline_type.",
            'value'       => $vendor_deadlines->pluck('id')->toArray(),
            'options'     => deadline_type([])->pluck('display_name', 'id')->toArray(),
        ])
    </div>
    @button(__('addworking.enterprise.vendor.billing_deadline.edit.record')."|icon:save|type:submit")
@endsection