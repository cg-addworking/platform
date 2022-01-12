@component('mail::message')
{{ __('emails.addworking.mission.purchase_order.send_to_referent.hello') }},<br/>

{{ __('emails.addworking.mission.purchase_order.send_to_referent.text_line1') }} {{$purchase_order->mission->label}} {{ __('emails.addworking.mission.purchase_order.send_to_referent.text_line2') }}<br/>
{{ __('emails.addworking.mission.purchase_order.send_to_referent.text_line3') }}

@component('mail::button', ['url' => $url])
{{ __('emails.addworking.mission.purchase_order.send_to_referent.see_order_form') }}
@endcomponent

{{ __('emails.addworking.mission.purchase_order.send_to_referent.cordially') }},

@lang('messages.confirmation.signature', ['name' => config('app.name')])

@slot('subcopy')
{{ __('emails.addworking.mission.purchase_order.send_to_referent.text_line4') }}: {{$url}}
@endslot

@endcomponent
