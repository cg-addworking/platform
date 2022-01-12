@inject('outboundInvoiceItemRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository")
@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")
@inject('feeRepository', "Components\Billing\Outbound\Application\Repositories\FeeRepository")

{{-- @todo fix this varname! --}}
@isset($outboundInvoice)
    @php $outbound_invoice = $outboundInvoice @endphp
@endisset

@component('foundation::layout.app._actions', ['model' => $outbound_invoice])
    @if ($outboundInvoiceRepository->hasParent($outbound_invoice))
        @can('indexCreditLine', [get_class($outbound_invoice), $outbound_invoice->enterprise])
            <a class="dropdown-item" href="{{ route('addworking.billing.outbound.credit_note.index', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                @icon('align-justify|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.credit_lines') }}
            </a>
        @endcan
    @else
        @can('indexAssociate', [get_class($outbound_invoice), $outbound_invoice->enterprise])
            <a class="dropdown-item" href="{{ route('addworking.billing.outbound.dissociate', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                @icon('file-invoice|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.supplier_invoice_included') }}
            </a>
        @endcan
        @can('index', [get_class($outboundInvoiceItemRepository->make()), $outbound_invoice->enterprise, $outbound_invoice])
            <a class="dropdown-item" href="{{ route('addworking.billing.outbound.item.index', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                @icon('align-justify|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.invoice_lines') }}
            </a>
        @endcan
    @endif

    @if ($outboundInvoiceRepository->hasParent($outbound_invoice))
        @if($feeRepository->getFeesOfOutboundInvoice($outbound_invoice)->count())
            @can('indexCreditLine', [get_class($outbound_invoice), $outbound_invoice->enterprise])
                <a class="dropdown-item" href="{{ route('addworking.billing.outbound.credit_note.index_fees', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                    @icon('calculator|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.addworking_commissions') }}
                </a>
            @endcan
        @else
            @can('indexCreditLine', [get_class($outbound_invoice), $outbound_invoice->enterprise])
                <a class="dropdown-item" href="{{ route('addworking.billing.outbound.credit_note.index_associate_fees', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                    @icon('calculator|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.addworking_commissions') }}
                </a>
            @endcan
        @endif
    @else
        @can('index', [get_class($feeRepository->make()), $outbound_invoice->enterprise, $outbound_invoice])
            <a class="dropdown-item" href="{{ route('addworking.billing.outbound.fee.index', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                @icon('calculator|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.addworking_commissions') }}
            </a>
        @endcan
    @endif

    @can('generateFile', [get_class($outbound_invoice), $outbound_invoice->enterprise, $outbound_invoice])
        <a class="dropdown-item" href="{{ route('addworking.billing.outbound.generate_file.create', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
            @icon('file-pdf|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.generate_pdf') }}
        </a>
    @endcan

    @if (! $outboundInvoiceRepository->hasParent($outbound_invoice))
        @can('createCreditNote', [get_class($outbound_invoice)])
            <a class="dropdown-item" href="{{ route('addworking.billing.outbound.credit_note.store', [$outbound_invoice->enterprise, $outbound_invoice]) }}">
                @icon('plus|mr:3|color:muted') {{ __('billing.outbound.application.views._actions.create_credit_note_invoice') }}
            </a>
        @endcan
    @endif
@endcomponent
