@component('mail::message')

{{ __('emails.addworking.mission.proposal_response.created.hello') }},

**{{$response->proposal->vendor->name}}** {{ __('emails.addworking.mission.proposal_response.created.text_line1') }} **{{$response->proposal->offer->label}}**

{{ __('emails.addworking.mission.proposal_response.created.text_line2') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.mission.proposal_response.created.access_to_response_to_proposal') }}
@endcomponent

{{ __('emails.addworking.mission.proposal_response.created.cordially') }},

{{ __('emails.addworking.mission.proposal_response.created.addworking_team') }}

@slot('subcopy')

{{ __('emails.addworking.mission.proposal_response.created.text_line3') }}: {{$url}}

@endslot

@endcomponent
