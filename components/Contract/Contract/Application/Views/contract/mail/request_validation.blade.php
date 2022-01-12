@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.request_validation.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.request_validation.sentence_one') }}
<br>
{{$contract_name}}
<br>
<br>
{{ __('components.contract.contract.application.views.contract.mail.request_validation.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.request_validation.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.request_validation.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.request_validation.access_contract') }}
@endcomponent

@endcomponent
