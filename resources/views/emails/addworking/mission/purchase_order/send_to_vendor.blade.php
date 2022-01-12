@component('mail::message')
{{ __('emails.addworking.mission.purchase_order.send_to_vendor.hello') }},<br/>
{{$purchase_order->mission->customer->name}} {{ __('emails.addworking.mission.purchase_order.send_to_vendor.text_line1') }} {{$purchase_order->mission->label}} {{ __('emails.addworking.mission.purchase_order.send_to_vendor.text_line2') }}<br/>
{{ __('emails.addworking.mission.purchase_order.send_to_vendor.text_line3') }}

@component('mail::button', ['url' => $url])
{{ __('emails.addworking.mission.purchase_order.send_to_vendor.see_order_form') }}
@endcomponent

{{ __('emails.addworking.mission.purchase_order.send_to_vendor.cordially') }},

{{ __('emails.addworking.mission.purchase_order.send_to_vendor.addworking_team') }}

@slot('subcopy')
{{ __('emails.addworking.mission.purchase_order.send_to_vendor.text_line4') }}: {{$url}}
@endslot

@endcomponent
