@component('mail::message')

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.hello') }} {{$response->proposal->offer->referent->name}},

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.text_line1') }} **{{$response->proposal->vendor->name}}** {{ __('emails.addworking.mission.proposal_response.ok_to_meet.text_line2') }} {{$date}} {{ __('emails.addworking.mission.proposal_response.ok_to_meet.concerning') }} **{{$response->proposal->offer->label}}**

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.text_line3') }}

@component('mail::button', ['url' => $url])
{{ __('emails.addworking.mission.proposal_response.ok_to_meet.see_response') }}
@endcomponent

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.cordially') }},

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.addworking_team') }}

@slot('subcopy')

{{ __('emails.addworking.mission.proposal_response.ok_to_meet.text_line4') }}: {{$url}}

@endslot

@endcomponent
