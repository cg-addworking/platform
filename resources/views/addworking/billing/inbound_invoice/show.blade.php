@extends('foundation::layout.app.show')

@section('title', __('addworking.billing.inbound_invoice.show.bills') ." {$inbound_invoice->number}")

@section('toolbar')
    @button(__('addworking.billing.inbound_invoice.show.return') ."|href:{$inbound_invoice->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('validate', $inbound_invoice)
        <a class="btn btn-sm btn-outline-success mr-2" href="#" onclick="confirm('Confirmer la validation ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('check') {{ __('addworking.billing.inbound_invoice.show.validate_invoice') }}
        </a>

        @push('modals')
            <form name="{{ $name }}" action="{{ route('addworking.billing.inbound_invoice.validation', compact('enterprise', 'inbound_invoice')) }}" method="post">
                @method('PATCH')
                @csrf
            </form>
        @endpush
    @endcan

    @can('index', [inbound_invoice_item(), $inbound_invoice])
        @button(__('addworking.billing.inbound_invoice.show.reconciliation') ."|href:".inbound_invoice_item([])->routes->index(@compact('enterprise', 'inbound_invoice'))."|icon:sitemap|color:primary|outline|sm|mr:2")
    @endif

    @can('updateComplianceStatus', inbound_invoice())
        @include('addworking.billing.inbound_invoice._dropdown_compliance_status')
    @endcan

    @can('createFromInboundInvoice', [outbound_invoice(), $inbound_invoice])
        @button(__('addworking.billing.inbound_invoice.show.create_outbound_invoice') ."|href:".route('addworking.billing.outbound.create.inbound_invoice', [$inbound_invoice->customer, $inbound_invoice])."|icon:file-invoice|color:success|outline|sm|mr:2")
    @endcan

    {{ $inbound_invoice->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.billing.inbound_invoice.show.dashboard') ."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.billing.inbound_invoice.show.companies') ."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.billing.inbound_invoice.show.my_bills') ."|href:{$inbound_invoice->routes->index}")
    @breadcrumb_item("{$inbound_invoice->number}|active")
@endsection

@section('content')
    @if($inbound_invoice->customer->isBusinessPlus())
        <div class="alert alert-warning" role="alert">
            {{__('addworking.billing.inbound_invoice.show.alert_business_plus')}}
        </div>
    @endif
    @support
        @if($inbound_invoice->getInboundInvoiceItemNotFound())
            <div class="alert alert-warning" role="alert">
                {{__('addworking.billing.inbound_invoice.show.alert_inbound_invoice_item_not_found')}}
            </div>
        @endif
    @endsupport
    @can('viewReconciliationInfo', $inbound_invoice)
        <table class="table">
            <tr>
                <td class="alert alert-{{ $inbound_invoice->validateAmounts() ? 'success' : 'danger' }}" colspan="3">
                    <h4 class="alert-heading">{{ $inbound_invoice->validateAmounts() ? __('addworking.billing.inbound_invoice.show.reconciliation_success_text') : __('addworking.billing.inbound_invoice.show.attention') }}</h4>
                </td>
            </tr>
            <tr>
                <td class="alert alert-{{ $inbound_invoice->validateAmounts() ? 'success' : 'danger' }}">
                    <b>{{ __('addworking.billing.inbound_invoice.show.information_provided_by_service_provider') }}</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.total_amount_excluding_taxes') }}<b>@money($inbound_invoice->amount_before_taxes)</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.amount_of_taxes') }}<b>@money($inbound_invoice->amount_of_taxes)</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.amount_all_taxes_included') }}<b>@money($inbound_invoice->amount_all_taxes_included)</b>
                </td>
                <td class="alert alert-{{ $inbound_invoice->validateAmounts() ? 'success' : 'danger' }}">
                    <b>{{ __('addworking.billing.inbound_invoice.show.information_calculated_from_mission_monitoring_lines') }}</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.total_amount_excluding_taxes') }}<b>@money($inbound_invoice->items->getAmountBeforeTaxes())</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.amount_of_taxes') }}<b>@money($inbound_invoice->items->getAmountOfTaxes())</b>
                    <br>{{ __('addworking.billing.inbound_invoice.show.amount_all_taxes_included') }}<b>@money($inbound_invoice->items->getAmountAllTaxesIncluded())</b>
                </td>

                @switch($inbound_invoice->compliance_status)
                    @case(inbound_invoice()::COMPLIANCE_STATUS_PENDING)
                    <td class="alert alert-info">
                        <b>{{ __('addworking.billing.inbound_invoice.show.in_processing_by_addworking') }}</b><br/>
                        {{ __('addworking.billing.inbound_invoice.show.waiting_administrative_verification') }}
                    </td>
                    @break

                    @case(inbound_invoice()::COMPLIANCE_STATUS_INVALID)
                    <td class="alert alert-danger">
                        <b>{{ __('addworking.billing.inbound_invoice.show.processed_by_addworking') }}</b><br/>
                        {{ __('addworking.billing.inbound_invoice.show.not_compliant_invoice') }}
                    </td>
                    @break

                    @case(inbound_invoice()::COMPLIANCE_STATUS_VALID)
                    <td class="alert alert-success">
                        <b>{{ __('addworking.billing.inbound_invoice.show.processed_by_addworking') }}</b><br/>
                        {{ __('addworking.billing.inbound_invoice.show.compliant_invoice') }}
                    </td>
                    @break
                @endswitch
            </tr>
            @can('index', [inbound_invoice_item(), $inbound_invoice])
            <tr>
                <td class="alert alert-{{ $inbound_invoice->validateAmounts() ? 'success' : 'danger' }} text-center" colspan="3" colspan="3">
                    <a href="{{inbound_invoice_item([])->routes->index(@compact('enterprise', 'inbound_invoice'))}}">
                        {{ __('addworking.billing.inbound_invoice.show.reconciliation_here') }}
                    </a>
                </td>
            </tr>
            @endcan
        </table>
    @endcan

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if ($inbound_invoice->file->exists)
                        {{ $inbound_invoice->file->views->iframe(['ratio' => "1by1"]) }}
                    @else
                        <div class="text-center"><b>La facture PDF n'existe pas.</b></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{ $inbound_invoice->views->html }}
        </div>
    </div>

@endsection
