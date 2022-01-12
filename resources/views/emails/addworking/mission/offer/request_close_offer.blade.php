@component('mail::message')
{{ __('emails.addworking.mission.offer.request_close_offer.greeting') }}

{{ $sender }} {{ __('emails.addworking.mission.offer.request_close_offer.retained_respondent') }} **{{ $offer->label }}**.

{{ __('emails.addworking.mission.offer.request_close_offer.confirm_choice') }}

{{ __('emails.addworking.mission.offer.request_close_offer.legal_statement') }}
 
{{ __('emails.addworking.mission.offer.request_close_offer.cordially') }}

{{ __('emails.addworking.mission.offer.request_close_offer.team_addworking') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.mission.offer.request_close_offer.mission_offer_close') }}
@endcomponent
@endcomponent
