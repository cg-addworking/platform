@component('mail::message')

{{ __('emails.sogetrel.user.passwork.shared.hello') }},

{{ $sender->name }} {{ __('emails.sogetrel.user.passwork.shared.text_line1') }} {{ $passwork->user->getPrimaryEnterprise()->name }} {{ __('emails.sogetrel.user.passwork.shared.near') }} {{ $reicever->name }}

{{ __('emails.sogetrel.user.passwork.shared.the') }} {{ date("Y/m/d") }} {{ __('emails.sogetrel.user.passwork.shared.at') }} {{ date("H:i") }}

@if($comment)
{{ __('emails.sogetrel.user.passwork.shared.with_for_remark') }} :
{{ $comment }}
@endif

@component('mail::button', ['url' => $url])
    {{ __('emails.sogetrel.user.passwork.shared.view_profile') }}
@endcomponent

@endcomponent
