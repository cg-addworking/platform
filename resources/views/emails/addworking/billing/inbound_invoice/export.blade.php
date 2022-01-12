@component('mail::message')

{{ __('addworking.billing.inbound_invoice.export.greetings') }}

{{ __('addworking.billing.inbound_invoice.export.sentence_one') }}

{{ __('addworking.billing.inbound_invoice.export.sentence_two') }}

{{ __('addworking.billing.inbound_invoice.export.thanks_you') }}

{{ __('addworking.billing.inbound_invoice.export.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('addworking.billing.inbound_invoice.export.download_button') }}
@endcomponent

@endcomponent
