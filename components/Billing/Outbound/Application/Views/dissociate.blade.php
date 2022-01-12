@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.create', ['action' => route('addworking.billing.outbound.dissociate.store', [$enterprise, $outboundInvoice])])

@section('title', __('billing.outbound.application.views.dissociate.title'). $outboundInvoice->getFormattedNumber()." de ".$enterprise->name)

@section('toolbar')
    @button(__('billing.outbound.application.views.dissociate.return')."|href:".route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice])."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('export', [get_class($outboundInvoice), $enterprise])
        @button(__('billing.outbound.application.views.dissociate.export')."|href:".route('addworking.billing.outbound.export', [$enterprise, $outboundInvoice])."|icon:download|color:outline-primary|outline|sm|mr:2")
    @endcan
    @can('indexAssociate', [get_class($outboundInvoice), $enterprise])
        @if (! $outboundInvoiceRepository->isValidated($outboundInvoice))
            @button(__('billing.outbound.application.views.dissociate.reset_invoice')."|href:".route('addworking.billing.outbound.associate', [$enterprise, $outboundInvoice])."|icon:file-invoice|color:outline-success|outline|sm|mr:2")
        @endif
    @endcan
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "associate"])
@endsection

@section('form')
    @if($items->count() > 0)
        <div class="mb-4">
            @support
                <button type="submit" class="btn btn-outline-danger btn-sm" style="display: none" id="button-submit">
                    <i class="fa fa-fw mr-2 fa-unlink"></i> {{ __('billing.outbound.application.views.dissociate.ungroup_selected_invoice') }}
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
                    @support
                        <col width="10%">
                    @endsupport
                </colgroup>
                <thead>
                @support
                    <th class="text-center"><input type="checkbox" id="select-all"></th>
                @endsupport
                @th(__('billing.outbound.application.views.dissociate.service_provider')."|not_allowed")
                @th(__('billing.outbound.application.views.dissociate.invoice_number')."|not_allowed|class:text-center")
                @th(__('billing.outbound.application.views.dissociate.billing_period')."|not_allowed|class:text-center")
                @th(__('billing.outbound.application.views.dissociate.payment_deadline')."|not_allowed|class:text-center")
                @th(__('billing.outbound.application.views.dissociate.amount_ht')."|not_allowed|class:text-center")
                @th(__('billing.outbound.application.views.dissociate.total')."|not_allowed|class:text-center")
                @th(__('billing.outbound.application.views.dissociate.status')."|not_allowed|class:text-center")
                @support
                    @th(__('billing.outbound.application.views.dissociate.action')."|not_allowed|class:text-center")
                @endsupport
                </thead>
                <tbody>
                @foreach ($items as $inbound_invoice)
                    <tr>
                        @support
                            <td class="text-center"><input type="checkbox" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}"></td>
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
                                @can('storeDissociate', [get_class($outboundInvoice), $enterprise])
                                    <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                        @icon('unlink|mr-3') <span>{{ __('billing.outbound.application.views.dissociate.dissociate') }}</span>
                                    </a>

                                    @push('forms')
                                        <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.dissociate.store', [$enterprise, $outboundInvoice]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="inbound_invoice[id][]" value="{{ $inbound_invoice->id }}">
                                        </form>
                                    @endpush
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
            <span>{{ __('billing.outbound.application.views.dissociate.the_enterprise') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views.dissociate.text_1') }}<br> {{ __('billing.outbound.application.views.dissociate.text_2') }} {{ $outboundInvoice->getMonth() }} {{ __('billing.outbound.application.views.dissociate.text_3') }} {{ $outboundInvoice->getDeadline()->display_name }}.</span>
            @can('indexAssociate', [get_class($outboundInvoice), $enterprise])
                @if (! $outboundInvoiceRepository->isValidated($outboundInvoice))
                    <div class="mt-4">
                        @button(__('billing.outbound.application.views.dissociate.associate_invoice')."|href:".route('addworking.billing.outbound.associate', [$enterprise, $outboundInvoice])."|icon:plus|color:outline-success|outline|sm|mr:2")
                    </div>
                @endif
            @endcan
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

