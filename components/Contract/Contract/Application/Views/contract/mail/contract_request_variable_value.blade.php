@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.sentence_one', ['contract_name' => $contract_name, 'pp_1' => $party_1, 'pp_2' => $party_2,]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.addworking_team') }}


@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.consult_variables') }}
@endcomponent

@component('mail::button', ['url' => $url_contract])
    {{ __('components.contract.contract.application.views.contract.mail.contract_request_variable_value.consult_contract') }}
@endcomponent

@endcomponent
