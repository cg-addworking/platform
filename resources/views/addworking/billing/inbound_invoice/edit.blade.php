@extends('foundation::layout.app.edit', ['action' => $inbound_invoice->routes->update, 'method' => 'PUT', 'enctype' => "multipart/form-data"])

@section('title', __('addworking.billing.inbound_invoice.edit.edit_invoice'))

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice.edit.return') ."|href:{$inbound_invoice->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice.edit.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice.edit.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.edit.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|href:{$inbound_invoice->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.edit.edit') ."|active")
@endsection

@section('form')
    @include('addworking.billing.inbound_invoice._warning')

    <fieldset class="mt-2 pt-2">
        @support
            <div class="row">
                <div class="col-12">
                    @form_group([
                        'text'         => __('addworking.billing.inbound_invoice.edit.service_provider'),
                        'type'         => "select",
                        'value'        => $inbound_invoice->enterprise->id,
                        'options'      => [$inbound_invoice->enterprise->id => $inbound_invoice->enterprise->name],
                        'disabled'     => true,
                    ])
                </div>
            </div>
        @endsupport
    </fieldset>

    {{ $inbound_invoice->views->form(['enterprise' => $enterprise, 'last_month' => $last_month]) }}

    <div class="text-right my-5">
        @button(__('addworking.billing.inbound_invoice.edit.register') ."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
