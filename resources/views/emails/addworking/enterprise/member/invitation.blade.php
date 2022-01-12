@component('mail::message')
{{ __('addworking.enterprise.member.invitation.notification.greeting') }}

{{ __('addworking.enterprise.member.invitation.notification.exchanges_with_subcontractors') }}

{{ __('addworking.enterprise.member.invitation.notification.invitation_to_join') }} '{{ $invitation->host->name }}' !!

{{ __('addworking.enterprise.member.invitation.notification.accept_invitation') }}

{{ __('addworking.enterprise.member.invitation.notification.need_support') }} : support@addworking.com

{{ __('addworking.enterprise.member.invitation.notification.see_you_soon') }}

{{ __('addworking.enterprise.member.invitation.notification.team_addworking') }}

@component('mail::button', ['url' => $url_accept])
{{ __('addworking.enterprise.member.invitation.notification.i_accept_invitation') }}
@endcomponent

@slot('subcopy')
 {{ __('addworking.enterprise.member.invitation.notification.copy_paste_url') }}

 {{ __('addworking.enterprise.member.invitation.notification.accept') }} : {{$url_accept}}

 {{ __('addworking.enterprise.member.invitation.notification.refuse') }}  : {{$url_refuse}}
@endslot

@endcomponent