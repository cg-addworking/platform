@extends('foundation::layout.app.show')

@section('title', Auth::user()->name)

@section('toolbar')
    @button(__('addworking.user.profile.index.notification')."|href:".route('addworking.user.notification_preferences.edit', auth()->user()->notificationPreferences)."|icon:bell|color:outline-primary|outline|sm|ml:2")
    @button(__('addworking.user.profile.index.edit_profile')."|href:".route('profile.edit')."|icon:cog|color:outline-primary|outline|sm|ml:2")
    @button(__('addworking.user.profile.index.edit_email')."|href:".route('profile.edit_email')."|icon:cog|color:outline-warning|outline|sm|ml:2")
    @button(__('addworking.user.profile.index.change_password')."|href:".route('profile.edit_password')."|icon:cog|color:outline-danger|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.profile.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.profile.index.profile_of')." ".Auth::user()->name."|active")
@endsection

@section('content')
<div class="row">
    @component('bootstrap::attribute', ['icon' => "picture", 'class' => "col-md-2 text-center"])
        @slot('label')
            {{ __('addworking.user.profile.index.profile_picture') }}
        @endslot

        @if (Auth::user()->picture->exists)
             <img src="{{ Auth::user()->picture->common_url }}"  class=" picture person img-thumbnail">
        @endif
    @endcomponent

    <div class="col-md-10">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.profile.index.user_identity') }}</legend>
        <br>
        <div class="row">
            @attribute((Auth::user()->firstname ?? 'n/a').'|class:col-md-6|icon:user|label:'.__('addworking.user.profile.index.first_name'))
            @attribute((Auth::user()->lastname ?? 'n/a').'|class:col-md-6|icon:user|label:'.__('addworking.user.profile.index.last_name'))
            @attribute(($enterprise->name ?? 'n/a').'|class:col-md-6|icon:building|label:'.__('addworking.user.profile.index.enterprise'))
            @attribute(($enterprise->pivot->job_title ?? 'n/a').'|class:col-md-6|icon:briefcase|label:'.__('addworking.user.profile.index.function'))
        </div>

        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.profile.index.address') }}</legend>
        <br>
        <div class="row">
            @attribute(($address->address ?? 'n/a').'|class:col-md-4|icon:map-marker|label:'.__('addworking.user.profile.index.address'))
            @attribute(($address->additionnal_address ?? 'n/a').'|class:col-md-4|icon:map-marker|label:'.__('addworking.user.profile.index.additional_address'))
            @attribute(($address->additionnal_address ?? 'n/a').'|class:col-md-4|icon:map-marker|label:'.__('addworking.user.profile.index.postal_code'))
        </div>

        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.profile.index.phone_numbers') }}</legend>
        <br>
        <div class="row">
            @if (!empty($phones))
                @foreach ($phones as $phone)
                    @attribute(($phone ?? 'n/a').'|class:col-md-4|icon:phone|label:'.__('addworking.user.profile.index.phone_number'))
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
