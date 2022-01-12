@component('mail::message')
{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.hello') }} {{$user->name}},<br/>

{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.text_line1') }}<br/>

{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.text_line2') }}<br/>
{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.text_line3') }}


@component('mail::button', ['url' => $url])
{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.finalize_my_registration') }}
@endcomponent

{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.cordially') }},

{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.addworking_team') }}

@slot('subcopy')
{{ __('emails.addworking.user.onboarding_process.unfinished_reminder.text_line4') }}: {{$url}}
@endslot

@endcomponent
