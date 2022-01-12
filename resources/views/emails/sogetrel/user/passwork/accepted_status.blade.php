@component('mail::message')

{{ __('emails.sogetrel.user.passwork.accepted_status.the_passwork') }} {{$vendor_name}} {{ __('emails.sogetrel.user.passwork.accepted_status.text_line1') }}

{{ __('emails.sogetrel.user.passwork.accepted_status.text_line2') }}

@component('mail::button', ['url' => $url])
{{ __('emails.sogetrel.user.passwork.accepted_status.consult_passwork') }}
@endcomponent

@endcomponent
