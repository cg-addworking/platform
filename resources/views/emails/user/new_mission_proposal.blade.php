@component('mail::message')

{{ __('emails.user.new_mission_proposal.hello') }} {{ $user->name }},

{{ __('emails.user.new_mission_proposal.text_line1') }}

{{ __('emails.user.new_mission_proposal.text_line2') }}

### {{ __('emails.user.new_mission_proposal.mission') }}

##### {{ __('emails.user.new_mission_proposal.description') }}

{{ $mission->description ?: 'n/a' }}

##### {{ __('emails.user.new_mission_proposal.details_terrif') }}

@component('mail::table')
|               |                                                                          |
| ------------- |-------------------------------------------------------------------------:|
| {{ __('emails.user.new_mission_proposal.terrif') }}         | @money($mission->amount)                                                 |
| {{ __('emails.user.new_mission_proposal.unit') }}         | {{ $mission->quantity}}x @lang("mission.mission.unit_{$mission->unit}")  |
| {{ __('emails.user.new_mission_proposal.location') }}  | {{ $mission->location }}                                                 |
@endcomponent

---

@component('mail::button', ['url' => route('mission.offer.accept', [$mission, $offer])])
    {{ __('emails.user.new_mission_proposal.accept_offer') }}
@endcomponentg

@component('mail::button', ['url' => route('mission.offer.refuse', [$mission, $offer]), 'color' => 'red'])
    {{ __('emails.user.new_mission_proposal.reject_offer') }}
@endcomponent

@endcomponent
