@extends('layout.app.edit', ['action' => route('addworking.enterprise.vendor.partnership.update', @compact('enterprise', 'vendor'))])

@section('title', "Activité courante {$enterprise->name} - {$vendor->name}")

@section('toolbar')
    @button(__('addworking.enterprise.vendor.partnership.edit.return')."|href:".route('addworking.enterprise.vendor.index', @compact('enterprise'))."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.partnership.edit.dashboard').'|href:'.route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.partnership.edit.my_providers')."|href:".route('addworking.enterprise.vendor.index', $enterprise))
    @breadcrumb_item("{$vendor->name}|href:{$vendor->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.partnership.edit.partnership')."|active")
@endsection

@section('form')
    @form_group([
        'text'     => __('addworking.enterprise.vendor.partnership.edit.activity_starts_at'),
        'type'     => "date",
        'required' => true,
        'name'     => "partnership.activity_starts_at",
        'value'    => is_null($partnership->activity_starts_at) ?: carbon($partnership->activity_starts_at)
    ])

    @form_group([
        'text'     => __('addworking.enterprise.vendor.partnership.edit.activity_ends_at'),
        'type'     => "date",
        'required' => false,
        'name'     => "partnership.activity_ends_at",
        'value'    => is_null($partnership->activity_ends_at) ?: carbon($partnership->activity_ends_at)
    ])

    @form_group([
        'text'     => __('addworking.enterprise.vendor.partnership.edit.vendor_external_id'),
        'type'     => "text",
        'name'     => "partnership.vendor_external_id",
        'value'    => $partnership->vendor_external_id,
    ])

    @support
        @form_group([
            'text'     => __('addworking.enterprise.vendor.partnership.edit.custom_management_fees_tag'),
            'type'     => "select",
            'options'  => [0 => "Non", 1 => "Oui"],
            'required' => true,
            'name'     => 'partnership.custom_management_fees_tag',
            'value'    => $partnership->custom_management_fees_tag,
        ])

        @form_group([
            'text'     => __('addworking.enterprise.vendor.partnership.edit.updated_by'),
            'type'     => "text",
            'value'    => user($partnership->updated_by)->name ?? "n/a",
            'disabled' => true
        ])

        @form_group([
            'text'     => __('addworking.enterprise.vendor.partnership.edit.updated_at'),
            'type'     => "text",
            'value'    => $partnership->updated_at,
            'disabled' => true
        ])
    @endsupport

    @button(__('addworking.enterprise.vendor.billing_deadline.edit.record')."|icon:save|type:submit")
@endsection
