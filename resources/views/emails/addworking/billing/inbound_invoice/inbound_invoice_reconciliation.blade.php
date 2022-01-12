@component('mail::message')
{{ $enterprise->name }} {{ __('addworking.billing.inbound_invoice.inbound_invoice_reconciliation.sentence') }}

@component('mail::button', ['url' => $url])
{{ __('addworking.billing.inbound_invoice.inbound_invoice_reconciliation.consult_invoice') }}
@endcomponent
@endcomponent
