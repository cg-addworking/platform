@component('mail::message')

{{ __('emails.iban.validation.hello') }} {{ $user->name }},

{{ __('emails.iban.validation.text_line1') }} {{ $iban->enterprise->name }}.

{{ __('emails.iban.validation.text_line2') }}

<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td width="50%" border="0" cellpadding="0" cellspacing="0" align="center">
            @component('mail::button', ['url' => $url_confirm, 'color' => 'green'])
                {{ __('emails.iban.validation.confirm') }}
            @endcomponent
        </td>
        <td width="50%" border="0" cellpadding="0" cellspacing="0" align="center">
            @component('mail::button', ['url' => $url_cancel, 'color' => 'red'])
                {{ __('emails.iban.validation.cancel') }}
            @endcomponent
        </td>
    </tr>
</table>

@lang('messages.confirmation.signature', ['name' => config('app.name')])

@endcomponent
