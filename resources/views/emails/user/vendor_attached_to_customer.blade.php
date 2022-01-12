@component('mail::message')
{{ __('emails.user.vendor_attached_to_customer.hello') }} {{ $user->firstname }} {{ $user->lastname }},

{{ __('emails.user.vendor_attached_to_customer.the_society') }} {{ $customer->name }} {{ __('emails.user.vendor_attached_to_customer.text_line1') }}

@component('mail::button', ['url' => $url_accept_invitation])
    {{ __('emails.user.vendor_attached_to_customer.accept_referrencing_by') }} {{ $customer->name }} {{ __('emails.user.vendor_attached_to_customer.on_addworking') }}
@endcomponent
@component('mail::button', ['url' => $url_refuse_invitation, 'color' => 'red'])
    {{ __('emails.user.vendor_attached_to_customer.reject_referrencing_by') }} {{ $customer->name }} {{ __('emails.user.vendor_attached_to_customer.on_addworking') }}
@endcomponent

{{ __('emails.user.vendor_attached_to_customer.text_line2') }}

{{ __('emails.user.vendor_attached_to_customer.text_line3') }}

{{ __('emails.user.vendor_attached_to_customer.best_regards') }},

{{ __('emails.user.vendor_attached_to_customer.addworking_team') }}

@endcomponent
