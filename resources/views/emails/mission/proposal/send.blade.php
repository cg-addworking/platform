@component('mail::message')
{{ __('emails.mission.proposal.send.hello') }},

@if(!$proposal->vendor->exists)
{{ __('emails.mission.proposal.send.the_society') }} {{ $proposal->missionOffer->customer->name }} {{ __('emails.mission.proposal.send.text_line1') }}
@endif

@if($proposal->vendor->exists)
{{ __('emails.mission.proposal.send.text_line2') }} {{ $proposal->missionOffer->customer->name }}.

{{ __('emails.mission.proposal.send.text_line3') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.mission.proposal.send.access_proposal') }}
@endcomponent

{{ __('emails.mission.proposal.send.summary') }}

**{{ __('emails.mission.proposal.send.client') }}**: {{ $proposal->missionOffer->customer->name }}

**{{ __('emails.mission.proposal.send.service_provider') }}**: {{ $proposal->vendor->name }}
@endif

{{ __('emails.mission.proposal.send.details') }}

<b>{{ __('emails.mission.proposal.send.purpose') }}</b>
{{ $proposal->missionOffer->label }}

<b>{{ __('emails.mission.proposal.send.description') }}</b>

{!! $proposal->missionOffer->description_html ?: 'n/a' !!}

<b>{{ __('emails.mission.proposal.send.location') }}</b>

{{ $proposal->missionOffer->departments->pluck('name')->implode(' | ') ?: 'n/a' }}

<b>{{ __('emails.mission.proposal.send.start_of_mission') }}</b> : {{ $proposal->missionOffer->starts_at_desired ?: 'n/a' }}

<b>{{ __('emails.mission.proposal.send.end_of_mission') }} </b> : {{ $proposal->missionOffer->ends_at ?: 'n/a' }}

@foreach($proposal->missionOffer->files as $file)
{{ __('emails.mission.proposal.send.additional_documents') }}

- {{ __('emails.mission.proposal.send.file') }}: {{ basename($file->path) }} [Télecharger]({{ domain_route($file->routes->download, $proposal->offer->customer) }})
@endforeach
___

@if(!$proposal->vendor->exists)

{{ __('emails.mission.proposal.send.text_line4') }} :
{{ __('emails.mission.proposal.send.text_line5') }}
@endif

@lang('messages.confirmation.signature', ['name' => config('app.name')])
@endcomponent
