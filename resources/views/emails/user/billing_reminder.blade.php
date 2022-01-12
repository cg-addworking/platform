@component('mail::message')

{{ __('emails.user.billing_reminder.hello') }} {{ $user->name }},

{{ __('emails.user.billing_reminder.text_line1') }} {{ $month }} {{ __('emails.user.billing_reminder.for') }} {{ $enterprise->name }} {{ __('emails.user.billing_reminder.text_line2') }}

@component('mail::button', ['url' => route('inbound_invoice.index')])
    {{ __('emails.user.billing_reminder.send_my_invoice') }}
@endcomponent

<b>{{ __('emails.user.billing_reminder.reminder') }}</b> - {{ __('emails.user.billing_reminder.all_invoices_for') }} {{ $enterprise->name }} {{ __('emails.user.billing_reminder.text_line3') }} {{ $enterprise->billing_ends_at }} {{ $month }} {{ __('emails.user.billing_reminder.text_line4') }} :

<b>
    {{ __('emails.user.billing_reminder.addworking') }}<br>
    {{ __('emails.user.billing_reminder.address_line1') }}<br>
    {{ __('emails.user.billing_reminder.address_line2') }}<br>
    {{ __('emails.user.billing_reminder.address_line3') }}
</b>

{{ __('emails.user.billing_reminder.text_line5') }}

{{ __('emails.user.billing_reminder.accounting_department') }} <br />

@endcomponent
