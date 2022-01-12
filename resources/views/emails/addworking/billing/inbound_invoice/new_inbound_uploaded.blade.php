@component('mail::message')

{{$inbound_invoice->enterprise->name}} {{ __('addworking.billing.inbound_invoice.new_inbound_uploaded.deposited_new_invoice') }}

{{ __('addworking.billing.inbound_invoice.new_inbound_uploaded.your_turn_to_play') }}

You rock !

![](https://media.giphy.com/media/PtfccZBHY2VBm/source.gif)

@component('mail::button', ['url' => $url])
{{ __('addworking.billing.inbound_invoice.new_inbound_uploaded.consult_invoice') }}
@endcomponent

@endcomponent
