@component('mail::message')

    {{$vendor->name}} {{ __('emails.addworking.enterprise.vendor.detached.dereferenced') }} {{$customer->name}} {{ __('emails.addworking.enterprise.vendor.detached.by') }} {{$user->name}}

@endcomponent

