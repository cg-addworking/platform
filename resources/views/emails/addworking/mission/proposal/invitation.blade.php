@component('mail::message')
{{ __('emails.addworking.mission.proposal.invitation.hello') }},

**{{ $invitation->host->name }}** {{ __('emails.addworking.mission.proposal.invitation.text_line1') }}
{{ __('emails.addworking.mission.proposal.invitation.text_line2') }} :
 - {{ __('emails.addworking.mission.proposal.invitation.text_line3') }}
 - {{ __('emails.addworking.mission.proposal.invitation.text_line4') }}
 - {{ __('emails.addworking.mission.proposal.invitation.text_line5') }} **{{ $invitation->host->name }}**!

{{ __('emails.addworking.mission.proposal.invitation.text_line6') }} :
 - {{ __('emails.addworking.mission.proposal.invitation.text_line7') }}
 - {{ __('emails.addworking.mission.proposal.invitation.email_text') }}

{{ __('emails.addworking.mission.proposal.invitation.see_you_soon') }}

{{ __('emails.addworking.mission.proposal.invitation.addworking_team') }}

@component('mail::button', ['url' => $url_accept])
{{ __('emails.addworking.mission.proposal.invitation.accept_invitation') }}
@endcomponent

@slot('subcopy')
{{ __('emails.addworking.mission.proposal.invitation.accept_option') }} :

{{ __('emails.addworking.mission.proposal.invitation.accept') }} : {{$url_accept}}

{{ __('emails.addworking.mission.proposal.invitation.reject') }}  : {{$url_refuse}}
@endslot

@endcomponent