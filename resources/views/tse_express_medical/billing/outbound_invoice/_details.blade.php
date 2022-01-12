@extends('foundation::layout.app.show')

@section('title', __('tse_express_medical.billing.outbound_invoice._details.tse_express_medical_details'))

@section('toolbar')

    @button(__('tse_express_medical.billing.outbound_invoice._details.return')."|href:".route('outbound_invoice.show', $invoice)."|icon:arrow-left|color:outline-primary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('tse_express_medical.billing.outbound_invoice._details.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('tse_express_medical.billing.outbound_invoice._details.bills').'|href:'.route('outbound_invoice.index') )
    @breadcrumb_item($invoice->label .'|href:'.route('outbound_invoice.show', $invoice) )
    @breadcrumb_item(__('tse_express_medical.billing.outbound_invoice._details.tse_express_medical_details')."|active")
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        @component('components.panel')
            @slot('table')
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.vendor_code') }}</th>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.last_name') }}</th>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.tour_code') }}</th>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.analytical_code') }}</th>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.agency_code') }}</th>
                            <th>{{ __('tse_express_medical.billing.outbound_invoice._details.quantity') }}</th>
                            <th class="text-right">{{ __('tse_express_medical.billing.outbound_invoice._details.unit_price') }}</th>
                            <th class="text-right">{{ __('tse_express_medical.billing.outbound_invoice._details.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ((new App\Jobs\Addworking\Billing\MakeOutboundInvoice($invoice))->prepareAnnex() as $item)
                            <tr>
                                <td>{{ $item->vendor_code }}</td>
                                <td>{{ $item->vendor->name }}</td>
                                <td>{{ $item->tour_code }}</td>
                                <td>{{ $item->analytical_code }}</td>
                                <td>{{ $item->agency_code }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-right">@money($item->unit_price)</td>
                                <td class="text-right">@money($item->amount_before_taxes)</td>
                            </tr>
                        @empty
                           <tr>
                               <td colspan="8" class="py-5">
                                   @lang('messages.empty')
                               </td>
                           </tr>
                        @endforelse
                    </tbody>
                </table>

            @endslot
        @endcomponent
    </div>
@endsection
