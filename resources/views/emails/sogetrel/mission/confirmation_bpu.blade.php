@component('mail::message')

{{ __('emails.sogetrel.mission.confirmation_bpu.hello') }} {{ $proposal->vendor->name }},

{{ __('emails.sogetrel.mission.confirmation_bpu.text_line1') }} {{ $proposal->label }}

@component('mail::button', ['url' => $url])
    {{ __('emails.sogetrel.mission.confirmation_bpu.access_bpu') }}
@endcomponent

{{ __('emails.sogetrel.mission.confirmation_bpu.cordially') }},

{{ __('emails.sogetrel.mission.confirmation_bpu.addworking_team') }}

@slot('subcopy')

{{ __('emails.sogetrel.mission.confirmation_bpu.text_line2') }}: {{ $proposal->routes->show }}

@endslot

@endcomponent
