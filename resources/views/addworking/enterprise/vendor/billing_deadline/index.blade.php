@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.vendor.billing_deadline.index.payment_due_for')." {$vendor->name}")

@section('toolbar')
    @button(__('addworking.enterprise.vendor.billing_deadline.index.return')."|href:".route('addworking.enterprise.vendor.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(sprintf(__('addworking.enterprise.vendor.billing_deadline.index.edit')."|href:%s|icon:edit|color:outline-primary|outline|sm", route('addworking.enterprise.vendor.billing_deadline.edit', @compact('enterprise', 'vendor'))))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.index.dashboard').'|href:'.route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.index.my_providers')."|href:".route('addworking.enterprise.vendor.index', $enterprise))
    @breadcrumb_item("{$vendor->name}|href:{$vendor->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.vendor.billing_deadline.index.payment_deadline')."|active")
@endsection

@section('table.head')
    @th(__('addworking.enterprise.vendor.billing_deadline.index.creation_date')."|not_allowed")
    @th(__('addworking.enterprise.vendor.billing_deadline.index.wording')."|not_allowed")
    @th(__('addworking.enterprise.vendor.billing_deadline.index.number_of_days')."|not_allowed")
    @th("Description|not_allowed")
@endsection

@section('table.body')
    @forelse ($items as $deadline_type)
        <tr>
            <td>@date($deadline_type->created_at)</td>
            <td>{{ $deadline_type->display_name }}</td>
            <td>{{ $deadline_type->value }}</td>
            <td>{{ $deadline_type->description }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
