@component('mail::message',['logo' => $invitation->host->logo])
{{ __('addworking.enterprise.vendor.invitation.notification.greeting', [], $local) }}

{{$invitation->host->name}} {{ __('addworking.enterprise.vendor.invitation.notification.wish_to_reference', [], $local) }}

{{ __('addworking.enterprise.vendor.invitation.notification.our_app', [], $local) }}

{{ __('addworking.enterprise.vendor.invitation.notification.register_free', [], $local) }} :
- {{ __('addworking.enterprise.vendor.invitation.notification.accept_invitation', [], $local) }}
- {{ __('addworking.enterprise.vendor.invitation.notification.company_information', [], $local) }}
- {{ __('addworking.enterprise.vendor.invitation.notification.legal_documents', [], $local) }}
- {{ __('addworking.enterprise.vendor.invitation.notification.and_its_done', [], $local) }} 😉

{{ __('addworking.enterprise.vendor.invitation.notification.have_questions', [], $local) }} :

{{ __('addworking.enterprise.vendor.invitation.notification.instant_messaging', [], $local) }} : {{ __('addworking.enterprise.vendor.invitation.notification.access_from_account', [], $local) }}

{{ __('addworking.enterprise.vendor.invitation.notification.email', [], $local) }} : {{ $local === 'de' ? 'kontakt@addworking.com' : 'support@addworking.com' }}

@component('mail::button', ['url' => $url_accept])
{{ __('addworking.enterprise.vendor.invitation.notification.i_accept_invitation', [], $local) }}
@endcomponent

@component('mail::button', ['url' => $url_refuse])
    {{ __('addworking.enterprise.vendor.invitation.notification.refuse', [], $local) }}
@endcomponent

{{ __('addworking.enterprise.vendor.invitation.notification.welcome', [], $local) }}

{{ __('addworking.enterprise.vendor.invitation.notification.team_addworking', [], $local) }}

@endcomponent
