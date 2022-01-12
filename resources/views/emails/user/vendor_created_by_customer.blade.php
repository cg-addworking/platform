@component('mail::message')
{{ __('emails.user.vendor_created_by_customer.hello') }} {{ $user->firstname }} {{ $user->lastname }}.

{{ __('emails.user.vendor_created_by_customer.the_society') }} {{ $customer->name }} {{ __('emails.user.vendor_created_by_customer.text_line1') }}

@component('mail::button', ['url' => route('vendor-accept-invitation', ['user' => $user->id, 'customer' => $customer->id])])
    {{ __('emails.user.vendor_created_by_customer.accept_referrencing_by') }} {{ $customer->name }} {{ __('emails.user.vendor_created_by_customer.on_addworking') }}
@endcomponent

{{ $customer->name }}, {{ __('emails.user.vendor_created_by_customer.text_line2') }}

{{ __('emails.user.vendor_created_by_customer.text_line3') }}

{{ __('emails.user.vendor_created_by_customer.text_line4') }}

{{ __('emails.user.vendor_created_by_customer.text_line5') }} :

{{ __('emails.user.vendor_created_by_customer.text_line6') }}
* {{ __('emails.user.vendor_created_by_customer.text_line7') }}
* {{ __('emails.user.vendor_created_by_customer.text_line8') }}
* {{ __('emails.user.vendor_created_by_customer.text_line9') }}
* {{ __('emails.user.vendor_created_by_customer.text_line10') }}

@component('mail::button', ['url' => route('vendor-accept-invitation', ['user' => $user->id, 'customer' => $customer->id])])
    {{ __('emails.user.vendor_created_by_customer.accept_referrencing_by') }} {{ $customer->name }} {{ __('emails.user.vendor_created_by_customer.on_addworking') }}
@endcomponent
@component('mail::button', ['url' => route('vendor-refuse-invitation', ['user' => $user->id, 'customer' => $customer->id]), 'color' => 'red'])
    {{ __('emails.user.vendor_created_by_customer.reject_referrencing_by') }} {{ $customer->name }} {{ __('emails.user.vendor_created_by_customer.on_addworking') }}
@endcomponent

{{ __('emails.user.vendor_created_by_customer.text_line11') }}

{{ __('emails.user.vendor_created_by_customer.best_regards') }},

{{ __('emails.user.vendor_created_by_customer.addworking_team') }}

{{ __('emails.user.vendor_created_by_customer.reminder_of_login_details') }}

{{ $user->email }}

{{ $password }}
@endcomponent