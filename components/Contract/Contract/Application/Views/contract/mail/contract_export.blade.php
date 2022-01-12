@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.export.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.export.sentence_one') }}
<br>
<br>
{{ __('components.contract.contract.application.views.contract.mail.export.sentence_two') }}

{{ __('components.contract.contract.application.views.contract.mail.export.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.export.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.export.consult_button') }}
@endcomponent

@endcomponent
