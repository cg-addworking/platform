@component('mail::message')
{{ __('emails.addworking.mission.offer.pending_offer.greeting') }}

{{ $offer->customer->name }} {{ __('emails.addworking.mission.offer.pending_offer.offer_closed') }} {{ $offer->label }}. {{ __('emails.addworking.mission.offer.pending_offer.no_longer_respond') }}

{{ __('emails.addworking.mission.offer.pending_offer.see_you_soon') }}

@lang('messages.confirmation.signature', ['name' => config('app.name')])
@endcomponent