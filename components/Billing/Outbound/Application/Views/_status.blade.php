{{-- @todo fix this varname! --}}
@isset($outboundInvoice)
    @php $outbound_invoice = $outboundInvoice @endphp
@endisset

@switch($outbound_invoice->getStatus())
    @case('pending')
        <span class="badge badge-pill badge-primary">{{ __('billing.outbound.application.views._status.pending') }}</span>
        @break

    @case('fees_calculated')
        <span class="badge badge-pill badge-success">{{ __('billing.outbound.application.views._status.fees_calculated') }}</span>
        @break;

    @case('validated')
        <span class="badge badge-pill badge-success">{{ __('billing.outbound.application.views._status.validated') }}</span>
        @break;

    @case('file_generated')
        <span class="badge badge-pill badge-success">{{ __('billing.outbound.application.views._status.file_generated') }}</span>
        @break;

    @case('partially_paid')
        <span class="badge badge-pill badge-secondary">{{ __('billing.outbound.application.views._status.partially_paid') }}</span>
        @break;

    @case('fully_paid')
        <span class="badge badge-pill badge-primary">{{ __('billing.outbound.application.views._status.fully_paid') }}</span>
        @break;

    @default
        <span>{{ $outbound_invoice->getStatus() }}</span>
        @break
@endswitch
