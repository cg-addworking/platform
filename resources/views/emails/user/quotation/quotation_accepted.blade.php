@component('mail::message')

{{ __('emails.user.quotation.quotation_accepted.hello') }} {{ $user->name }},

{{ __('emails.user.quotation.quotation_accepted.text_line1') }} <b>{{ $mission->label }}</b> {{ __('emails.user.quotation.quotation_accepted.text_line2') }}

<b> {{ __('emails.user.quotation.quotation_accepted.text_line3') }} : </b>

{{ $mission }}

<br />
{{ __('emails.user.quotation.quotation_accepted.best_regards') }},

{{ __('emails.user.quotation.quotation_accepted.addworking_team') }}


@endcomponent
