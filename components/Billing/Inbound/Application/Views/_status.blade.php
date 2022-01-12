@switch ($invoice->status)
    @case (inbound_invoice()::STATUS_TO_VALIDATE)
        <span class="badge badge-pill badge-primary">{{ __('addworking.billing.inbound_invoice._status.validate') }}</span>
        @break
    @case (inbound_invoice()::STATUS_PENDING)
        <span class="badge badge-pill badge-warning">{{ __('addworking.billing.inbound_invoice._status.pending') }}</span>
        @break
    @case (inbound_invoice()::STATUS_VALIDATED)
        <span class="badge badge-pill badge-success">{{ __('addworking.billing.inbound_invoice._status.validated') }}</span>
        @break
    @case (inbound_invoice()::STATUS_PAID)
        <span class="badge badge-pill badge-success">{{ __('addworking.billing.inbound_invoice._status.paid') }}</span>
        @break
    @default
        <span class="badge badge-pill badge-secondary">{{ __('addworking.billing.inbound_invoice._status.unknown') }}</span>
        @break
@endswitch
