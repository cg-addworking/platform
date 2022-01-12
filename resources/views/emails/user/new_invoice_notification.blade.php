@component('mail::message')

{{ __('emails.user.new_invoice_notification.hello') }} {{ $user->name }},

{{ __('emails.user.new_invoice_notification.text_line1') }}

@component('mail::button', ['url' => route('outbound_invoice.index', $user->enterprise)])
    {{ __('emails.user.new_invoice_notification.access_invoices') }}
@endcomponent

@endcomponent
