@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.sentence_one', ['contract_name' => $contract_name, 'owner' => $owner]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_to_validate_on_yousign.consult_button') }}
@endcomponent
@endcomponent