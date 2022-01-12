@component('mail::message')

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_vendor.greetings') }}

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_vendor.sentence_one', ['contract_name' => $contract->name, 'enterprise_name' => $contract->getEnterprise()->name]) }} @date(Carbon\Carbon::now()->addDays($day))


{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_vendor.thank_you') }}

{{ __('components.contract.contract.application.views.contract.mail.expiring_contract_vendor.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.expiring_contract_vendor.url') }}
@endcomponent

@endcomponent
