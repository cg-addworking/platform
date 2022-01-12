@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.sentence_one', ['type' => $type, 'owner' => $owner]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_to_complete.consult_button') }}
@endcomponent
@endcomponent
