@extends('foundation::layout.app.show')

@section('title', __('addworking.user.profile.edit_password.change_password'))

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.profile.edit_password.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.profile.edit_password.profile')."|href:".route('profile'))
    @breadcrumb_item(__('addworking.user.profile.edit_password.change_password').'|active')
@endsection

@section('content')
    @component('bootstrap::form', ['method' => "post", 'action' => route('profile.save_password'), 'class' => "mt-5"])
        @form_group([
            'text'     => __('addworking.user.profile.edit_password.current_password'),
            'type'     => "password",
            'name'     => "password",
            'required' => true,
        ])

        @form_group([
            'text'     => __('addworking.user.profile.edit_password.new_password'),
            'type'     => "password",
            'name'     => "new_password",
            'required' => true,
        ])

        @form_group([
            'text'     => __('addworking.user.profile.edit_password.repeat_new_password'),
            'type'     => "password",
            'name'     => "new_password_confirmation",
            'required' => true,
        ])

        <div class="text-right mt-5">
            @button(__('addworking.user.profile.edit_password.record').'|type=submit|icon:save|color:success|outline')
        </div>
    @endcomponent
@endsection
