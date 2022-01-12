@component('mail::message')
{{ __('offer::offer.send_to_enterprise.email.hello') }},

{{ __('offer::offer.send_to_enterprise.email.text_line2') }} {{ $offer->getCustomer()->name }}.

{{ __('offer::offer.send_to_enterprise.email.text_line3') }}

@component('mail::button', ['url' => $url])
{{ __('offer::offer.send_to_enterprise.email.access_proposal') }}
@endcomponent

{{ __('offer::offer.send_to_enterprise.email.details') }}

**{{ __('offer::offer.send_to_enterprise.email.client') }}**: {{ $offer->getCustomer()->name }}

<b>{{ __('offer::offer.send_to_enterprise.email.purpose') }}</b>
{{ $offer->getLabel() }}

<b>{{ __('offer::offer.send_to_enterprise.email.description') }}</b>

{!! $offer->getDescriptionHtml() ?? 'n/a' !!}

<b>{{ __('offer::offer.send_to_enterprise.email.location') }}</b>

{{ $offer->getDepartments()->pluck('name')->implode(' | ') ?: 'n/a' }}

<b>{{ __('offer::offer.send_to_enterprise.email.start_of_mission') }}</b> : @date($offer->getStartsAtDesired())<br>

<b>{{ __('offer::offer.send_to_enterprise.email.end_of_mission') }} </b> : @date($offer->getEndsAt())<br>

@lang('messages.confirmation.signature', ['name' => config('app.name')])
@endcomponent
