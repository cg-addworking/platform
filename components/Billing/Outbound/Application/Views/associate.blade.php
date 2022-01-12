@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.associate.store', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.associate.remains_to_be_invoiced')." (période ".$outboundInvoice->getMonth()." - ".$outboundInvoice->getDeadline()->display_name.") de l'entreprise {$enterprise->name}")

@section('toolbar')
    @button(__('billing.outbound.application.views.associate.return')."|href:".route('addworking.billing.outbound.dissociate', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "associate"])
@endsection

@section('form')
    <div class="alert alert-primary" role="alert">
        {{ __('billing.outbound.application.views.associate.note') }}
    </div>
    @if($items->count() > 0)
        <div class="mb-4">
            @support
                <button type="submit" class="btn btn-outline-success btn-sm" style="display: none" id="button-submit">
                    <i class="fa fa-fw mr-2 fa-link"></i> {{ __('billing.outbound.application.views.associate.associate_selected_invoice') }}
                </button>
            @endsupport
        </div>
        <div class="table-responsive" id="invoice-list" style="min-height: 500px">
            <table class="table table-hover">
                <colgroup>
                    @support
                        <col width="5%">
                    @endsupport
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    @support
                        <th class="text-center"><input type="checkbox" id="select-all"></th>
                    @endsupport
                    @th(__('billing.outbound.application.views.associate.service_provider')."|not_allowed")
                    @th(__('billing.outbound.application.views.associate.invoice_number')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.associate.billing_period')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.associate.payment_deadline')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.associate.amount_ht')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.associate.total')."|not_allowed|class:text-center")
                    @th(__('billing.outbound.application.views.associate.status')."|not_allowed|class:text-center")
                    @support
                        @th(__('billing.outbound.application.views.associate.action')."|not_allowed|class:text-center")
                    @endsupport
                </thead>
                <tbody>
                @foreach ($items as $inbound_invoice)
                    <tr>
                        @support
                            @if (! in_array($inbound_invoice->status, ["pending_association", "validated"]))
                                <td></td>
                            @else
                                <td class="text-center"><input type="checkbox" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}"></td>
                            @endif
                        @endsupport
                        <td><a href="{{ $inbound_invoice->enterprise->routes->show }}" target="_blank">{{ $inbound_invoice->enterprise->name }}</a></td>
                        <td class="text-center"><a href="{{ $inbound_invoice->routes->show }}" target="_blank">{{ $inbound_invoice->number }}</a></td>
                        <td class="text-center"> {{ $inbound_invoice->month }} </td>
                        <td class="text-center"> {{ $inbound_invoice->deadline()->first()->display_name }} </td>
                        <td class="text-center">@money($inbound_invoice->amount_before_taxes)</td>
                        <td class="text-center">@money($inbound_invoice->amount_all_taxes_included)</td>
                        <td class="text-center"> @include('addworking.billing.inbound_invoice._status') </td>
                        @support
                            <td class="text-center">
                                @can('storeAssociate', [get_class($outboundInvoice), $enterprise])
                                    @if (in_array($inbound_invoice->status, ["pending_association", "validated"]))
                                        <a class="btn btn-sm btn-outline-success" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                            @icon('link|mr-3') <span>{{ __('billing.outbound.application.views.associate.associate') }}</span>
                                        </a>
                                        @push('forms')
                                            <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.associate.store', [$enterprise, $outboundInvoice]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}">
                                            </form>
                                        @endpush
                                    @endif
                                @endcan
                            </td>
                        @endsupport
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <span>{{ __('billing.outbound.application.views.associate.the_enterprise') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views.associate.text_1') }}<br> {{ __('billing.outbound.application.views.associate.text_2') }} {{ $outboundInvoice->getMonth() }} {{ __('billing.outbound.application.views.associate.text_3') }} {{ $outboundInvoice->getDeadline()->display_name }}.</span>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function checked_counter() {
            var count = $('#invoice-list input:checkbox:checked:not(#select-all)').length;
            $('#button-submit')[count == 0 ? 'hide': 'show']();
        }

        $(function () {
            $('#select-all').click(function () {
                $('#invoice-list input:checkbox').prop('checked', $(this).is(':checked'));
                checked_counter()
            });

            $('#invoice-list input:checkbox').change(checked_counter);
        })
    </script>
@endpush

