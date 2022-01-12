@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.sentence_one', ['contract_name' => $contract_name, 'owner' => $owner]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_to_sign.consult_button') }}
@endcomponent
@endcomponent
