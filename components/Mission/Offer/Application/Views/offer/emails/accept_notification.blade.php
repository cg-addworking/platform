@component('mail::message')
{{ __('emails.addworking.mission.offer.accept_offer.greeting') }}

{{ __('emails.addworking.mission.offer.accept_offer.response_to_mission_proposal') }} {{ $offer->getLabel() }} {{ __('emails.addworking.mission.offer.accept_offer.validate') }} {{ $offer->getCustomer()->name }}.

{{ __('emails.addworking.mission.offer.accept_offer.congratulations') }}
 
{{ __('emails.addworking.mission.offer.accept_offer.legal_statement') }}
 
{{ __('emails.addworking.mission.offer.accept_offer.cordially') }}

{{ __('emails.addworking.mission.offer.accept_offer.team_addworking') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.mission.offer.accept_offer.i_consult') }}
@endcomponent
@endcomponent