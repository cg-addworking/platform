@component('mail::message')
{{ __('emails.mission.proposal.assign.hello') }},

{{ __('emails.mission.proposal.assign.text_line1') }} {{ $proposal->missionOffer->customer->name }} {{ __('emails.mission.proposal.assign.text_line2') }}

{{ __('emails.mission.proposal.assign.text_line3') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.mission.proposal.assign.access_mission') }}
@endcomponent

@lang('messages.confirmation.signature', ['name' => config('app.name')])
@endcomponent
