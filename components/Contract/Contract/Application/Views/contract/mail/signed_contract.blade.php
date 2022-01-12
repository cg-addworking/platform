@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.signed_contract.greetings', ['name' => $name]) }}

{{ __('components.contract.contract.application.views.contract.mail.signed_contract.sentence_one', ['contract_name' => $contract_name]) }}

{{ __('components.contract.contract.application.views.contract.mail.signed_contract.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.signed_contract.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.signed_contract.consult_button') }}
@endcomponent
@endcomponent