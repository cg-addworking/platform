@component('foundation::layout.app._table_row_empty')
    <span>{{ __('billing.outbound.application.views._table_head.the_enterprise') }} <b>{{ $enterprise->name }}</b> {{ __('billing.outbound.application.views._table_head.does_not_have_invoices') }}</span>
    @slot('create')
        @can('create', [OutboundInvoice::class])
            @button(sprintf(__('billing.outbound.application.views._table_head.create_invoice')."|href:%s|icon:plus|color:outline-success|outline|sm|mr:2", route('addworking.billing.outbound.create', $enterprise)))
        @endcan
    @endslot
@endcomponent