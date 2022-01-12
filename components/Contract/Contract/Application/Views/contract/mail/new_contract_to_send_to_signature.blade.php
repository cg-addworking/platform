@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.sentence_one', ['contract_name' => $contract_name,]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.sentence_three') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_to_send_to_signature.consult_button') }}
@endcomponent
@endcomponent