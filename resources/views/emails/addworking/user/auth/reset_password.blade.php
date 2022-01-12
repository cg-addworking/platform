@component('mail::message')
{{ __('emails.addworking.user.auth.reset_password.hello') }} {{$firstname}} {{$lastname}},

{{ __('emails.addworking.user.auth.reset_password.text_line1') }}

{{ __('emails.addworking.user.auth.reset_password.text_line2') }}:

@component('mail::button', ['url' => $url])
{{ __('emails.addworking.user.auth.reset_password.reset_my_password') }}
@endcomponent

{{ __('emails.addworking.user.auth.reset_password.text_line3') }}

{{ __('emails.addworking.user.auth.reset_password.text_line4') }}

{{ __('emails.addworking.user.auth.reset_password.cordially') }},

{{ __('emails.addworking.user.auth.reset_password.addworking_team') }}

@slot('subcopy')
{{ __('emails.addworking.user.auth.reset_password.text_line5') }} : {{$url}}
@endslot

@endcomponent