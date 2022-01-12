@component('mail::message')
{{ __('emails.sogetrel.user.passwork.share.hello') }} {{ $reicever->name }},

{{ __('emails.sogetrel.user.passwork.share.text_line1') }}

{{ __('emails.sogetrel.user.passwork.share.text_line2') }}

{{ __('emails.sogetrel.user.passwork.share.cordially') }},

{{ $sender->name }}

@component('mail::button', ['url' => $url])
    {{ __('emails.sogetrel.user.passwork.share.view_profile') }}
@endcomponent

@if($comment)
{{ __('emails.sogetrel.user.passwork.share.note') }} :
{{ $comment }}
@endif
@endcomponent
