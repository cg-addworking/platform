@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.greetings', [], $contractualization_language) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.sentence_one', ['contract_name' => $contract_name], $contractualization_language) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.sentence_two', [], $contractualization_language) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.thanks_you', [], $contractualization_language) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.addworking_team', [], $contractualization_language) }}


@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.contract_needs_variables_values.consult_contract', [], $contractualization_language) }}
@endcomponent

@endcomponent
