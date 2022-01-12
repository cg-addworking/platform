@component('mail::message')
{{ __('addworking.billing.inbound_invoice.export_ready.greeting') }} {{ $user->name }},

{{ __('addworking.billing.inbound_invoice.export_ready.email_sentence') }}

{{ __('addworking.billing.inbound_invoice.export_ready.have_a_good_day') }}.
@endcomponent
