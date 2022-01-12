@extends('foundation::layout.auth')

@section('title', __('addworking.user.auth.passwords.reset.reset_password'))

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="prevent-multiple-submits">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        @form_group([
            'type'        => "email",
            'name'        => "email",
            'text'        => __('addworking.user.auth.passwords.reset.email_address'),
            'required'    => true,
            '_attributes' => ['autofocus' => true],
        ])

        @form_group([
            'type'        => "password",
            'name'        => "password",
            'text'        => __('addworking.user.auth.passwords.reset.password'),
            'required'    => true,
        ])

        @form_group([
            'type'        => "password",
            'name'        => "password_confirmation",
            'text'        => __('addworking.user.auth.passwords.reset.confirm_password'),
            'required'    => true,
        ])

        @button(__('addworking.user.auth.passwords.reset.record')."|type:submit")
    </form>
@endsection
