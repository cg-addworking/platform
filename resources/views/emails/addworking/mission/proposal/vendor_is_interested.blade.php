@component('mail::message')

{{ __('emails.addworking.mission.proposal.vendor_is_interested.hello') }},

**{{$proposal->vendor->name}}** {{ __('emails.addworking.mission.proposal.vendor_is_interested.interested_in_mission_proposal') }} **{{$proposal->offer->label}}**
{{ __('emails.addworking.mission.proposal.vendor_is_interested.text_line1') }} {{$date}}

{{ __('emails.addworking.mission.proposal.vendor_is_interested.comment') }} {{ $proposal->comments->last()->content }}

{{ __('emails.addworking.mission.proposal.vendor_is_interested.text_line2') }}

@component('mail::button', ['url' => $url])
{{ __('emails.addworking.mission.proposal.vendor_is_interested.view_proposal') }}
@endcomponent

{{ __('emails.addworking.mission.proposal.vendor_is_interested.cordially') }},

{{ __('emails.addworking.mission.proposal.vendor_is_interested.addworking_team') }}

@slot('subcopy')
{{ __('emails.addworking.mission.proposal.vendor_is_interested.text_line3') }}: {{$url}}
@endslot

@endcomponent
