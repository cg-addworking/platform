@component('mail::message')

{{ __('emails.user.quotation.quotation_refused.hello') }} {{ $user->name }},

{{ __('emails.user.quotation.quotation_refused.text_line1') }} <b>{{ $mission->label }}</b> {{ __('emails.user.quotation.quotation_refused.text_line2') }}

<b> {{ __('emails.user.quotation.quotation_refused.text_line3') }} : </b>

{{ $mission }}

<br />
{{ __('emails.user.quotation.quotation_refused.best_regards') }},

{{ __('emails.user.quotation.quotation_refused.addworking_team') }}

@endcomponent
