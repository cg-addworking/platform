@component('mail::message')
{{ __('emails.user.confirmation_vendors_paid.hello') }} {{ $user->firstname }} {{ $user->lastname }},

{{ __('emails.user.confirmation_vendors_paid.text_line1') }} {{ $outboundInvoice->number()->first()->number ?? "n/a" }} {{ __('emails.user.confirmation_vendors_paid.text_line2') }}

@component('mail::button', ['url' => $url])
{{ __('emails.user.confirmation_vendors_paid.view_invoice') }}
@endcomponent

{{ __('emails.user.confirmation_vendors_paid.text_line3') }}

{{ __('emails.user.confirmation_vendors_paid.best_regards') }},

{{ __('emails.user.confirmation_vendors_paid.addworking_team') }}

@endcomponent
