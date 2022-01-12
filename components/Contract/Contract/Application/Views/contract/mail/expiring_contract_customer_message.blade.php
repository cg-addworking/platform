@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.greetings') }}

@if($day == '30')

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.sentence_one', ['enterprise_name' => $enterprise->name]) }}

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.sentence_two') }}

@elseif($day == '1')

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.sentence_three', ['enterprise_name' => $enterprise->name]) }} @date(Carbon\Carbon::now()->addDay())

@endif

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.thank_you') }}

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.expiring_contract_customer.url') }}
@endcomponent

@endcomponent
