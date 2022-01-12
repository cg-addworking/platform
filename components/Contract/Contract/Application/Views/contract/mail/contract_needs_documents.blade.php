@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.sentence_one', ['contract_name' => $contract_name, 'enterprise_name' => $enterprise_name]) }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.addworking_team') }}


@component('mail::button', ['url' => $url_doc])
    {{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.consult_doc') }}
@endcomponent

@component('mail::button', ['url' => $url_contract])
    {{ __('components.contract.contract.application.views.contract.mail.contract_needs_documents.consult_contract') }}
@endcomponent

@endcomponent
