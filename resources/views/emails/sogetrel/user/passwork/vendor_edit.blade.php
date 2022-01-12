@component('mail::message')

{{ __('emails.sogetrel.user.passwork.vendor_edit.hello') }}

{{ __('emails.sogetrel.user.passwork.vendor_edit.text_line1') }}

@component('mail::button', ['url' => $url])
{{ __('emails.sogetrel.user.passwork.vendor_edit.consult_passwork') }}
@endcomponent

{{ __('emails.sogetrel.user.passwork.vendor_edit.text_line2') }}

{{ __('emails.sogetrel.user.passwork.vendor_edit.signature') }}

@endcomponent