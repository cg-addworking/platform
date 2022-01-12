@extends('foundation::layout.app.index')

@section('title', __('addworking.billing.inbound_invoice.index.my_bills'))

@section('toolbar')
    @can('create', [inbound_invoice(), $enterprise])
        @button(__('addworking.billing.inbound_invoice.index.create_invoice') ."|href:".inbound_invoice([])->routes->create(compact('enterprise'))."|icon:plus|color:outline-success|outline|sm|mr:2")
    @else
        <span title="{{ __('addworking.billing.inbound_invoice.index.cannot_create_invoice_sentence') }}">
            @button(__('addworking.billing.inbound_invoice.index.create_invoice') ."|href:#|icon:plus|color:light|sm|mr:2|disabled:disabled")
        </span>
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice.index.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice.index.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.index.my_bills') ."|active")
@endsection

@section('table.head')
    @th(__('addworking.billing.inbound_invoice.index.created_date') ."|column:created_at")
    @th(__('addworking.billing.inbound_invoice.index.service_provider') ."|not_allowed")
    @th(__('addworking.billing.inbound_invoice.index.customer') ."|not_allowed")
    @th(__('addworking.billing.inbound_invoice.index.number') ."|not_allowed")
    @th(__('addworking.billing.inbound_invoice.index.status') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice.index.amount_excluding') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice.index.tax_amount') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice.index.amount_including_tax') ."|not_allowed|class:text-center")
    @th(__('addworking.billing.inbound_invoice.index.action') ."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td>
        @form_control([
            'type'  => "date",
            'name'  => "filter[created_at]",
            'value' => request()->input('filter.created_at')
        ])
    </td>
    <td>
        @form_control([
            'type'  => "text",
            'name'  => "filter[enterprise]",
            'value' => request()->input('filter.enterprise')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[customer]",
        'value' => request()->input('filter.customer')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[number]",
        'value' => request()->input('filter.number')
        ])
    </td>
    <td>
        @form_control([
        'type'    => "select",
        'name'    => "filter[status]",
        'options' => inbound_invoice()::getAvailableStatuses(true),
        'value'   => request()->input('filter.status')
        ])
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td>@button(['icon' => "check", 'type' => "sumbit"])</td>
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @cannot('create', [inbound_invoice(), $enterprise])
    <div class="alert alert-warning" role="alert">
        <span>{{ __('addworking.billing.inbound_invoice.index.cannot_create_invoice_sentence') }}</span><br>
        <a href="{{ route('enterprise.iban.create', $enterprise) }}" class=" btn btn-sm btn-warning mt-1">{{ __('addworking.billing.inbound_invoice.index.fill_iban_button') }}</a>
    </div>
    @endcannot
    @forelse ($items as $invoice)
        <tr>
            <td>@date($invoice->created_at)</td>
            <td>{{ $invoice->enterprise->views->link }}</td>
            <td>{{ $invoice->customer->views->link }}</td>
            <td>{{ $invoice->number }}</td>
            <td class="text-center">{{ $invoice->views->status }}</td>
            <td class="text-center">@money($invoice->amount_before_taxes)</td>
            <td class="text-center">@money($invoice->amount_of_taxes)</td>
            <td class="text-center">@money($invoice->amount_all_taxes_included)</td>
            <td class="text-right">{{ $invoice->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="99" class="text-center">
                <div class="p-5">
                    @icon('frown-open') {{ __('addworking.billing.inbound_invoice.index.empty') }}
                </div>
            </td>
        </tr>
    @endforelse
@endsection
