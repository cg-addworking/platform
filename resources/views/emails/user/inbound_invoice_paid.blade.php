@component('mail::message')
{{ __('emails.user.inbound_invoice_paid.hello') }} {{ $user->firstname }} {{ $user->lastname }},

{{ __('emails.user.inbound_invoice_paid.text_line1') }}{{ $inboundInvoice->number }}.

@component('mail::button', ['url' => $url])
{{ __('emails.user.inbound_invoice_paid.view_invoice') }}
@endcomponent

{{ __('emails.user.inbound_invoice_paid.text_line2') }}

{{ __('emails.user.inbound_invoice_paid.best_regards') }},

{{ __('emails.user.inbound_invoice_paid.addworking_team') }}

@endcomponent
