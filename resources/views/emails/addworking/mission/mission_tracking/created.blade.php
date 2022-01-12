@component('mail::message')
{{ __('emails.addworking.mission.mission_tracking.created.greeting') }}

{{ __('emails.addworking.mission.mission_tracking.created.new_vision_tracking') }} {{ $mission->offer->label }}
{{ __('emails.addworking.mission.mission_tracking.created.validate') }}


@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.mission.mission_tracking.created.access_mission_tracking') }}
@endcomponent

{{ __('emails.addworking.mission.mission_tracking.created.cordially') }}

{{ __('emails.addworking.mission.mission_tracking.created.team_addworking') }}

@slot('subcopy')

{{ __('emails.addworking.mission.mission_tracking.created.copy_paste_url') }}: {{$url}}

@endslot

@endcomponent
