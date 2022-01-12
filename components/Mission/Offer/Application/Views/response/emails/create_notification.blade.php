@component('mail::message')

{{ __('offer::response.create.email.hello') }},

**{{ $response->getEnterprise()->name }}** {{ __('offer::response.create.email.text_line1') }} **{{ $response->getOffer()->getLabel() }}**

{{ __('offer::response.create.email.text_line2') }}

@component('mail::button', ['url' => $url])
    {{ __('offer::response.create.email.access_to_response_to_proposal') }}
@endcomponent

{{ __('offer::response.create.email.cordially') }},

{{ __('offer::response.create.email.addworking_team') }}

@slot('subcopy')

    {{ __('offer::response.create.email.text_line3') }}: {{$url}}

@endslot

@endcomponent
