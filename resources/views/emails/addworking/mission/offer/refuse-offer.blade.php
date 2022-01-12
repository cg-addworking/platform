@component('mail::message')
{{ __('emails.addworking.mission.offer.refuse_offer.greeting') }}

{{ __('emails.addworking.mission.offer.refuse_offer.your_response') }} {{ $offer->label }} {{ __('emails.addworking.mission.offer.refuse_offer.has_refused_by') }} {{ $offer->customer->name }}.

@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.mission.offer.refuse_offer.i_consult') }}
@endcomponent

{{ __('emails.addworking.mission.offer.refuse_offer.see_you_soon') }}

@lang('messages.confirmation.signature', ['name' => config('app.name')])
@endcomponent
