@extends('foundation::layout.auth')

@section('title', __('addworking.user.auth.login.log_in'))

@section('content')
    <form method="POST" action="{{ route('login') }}" class="prevent-multiple-submits">
        @csrf

        @form_group([
            'type'        => 'email',
            'name'        => 'email',
            'required'    => true,
            'text'        => __('addworking.user.auth.login.email_address'),
            '_attributes' => ['autofocus' => true],
        ])

        @form_group([
            'type'        => "password",
            'name'        => "password",
            'required'    => true,
            'text'        => __('addworking.user.auth.login.password'),
        ])

        @button(__('addworking.user.auth.login.login').'|type:submit')

        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('addworking.user.auth.login.forgot_password') }}
        </a>
    </form>
@endsection
