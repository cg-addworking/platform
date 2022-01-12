@extends('foundation::layout.auth')

@section('title', __('addworking.user.auth.passwords.email.reset_password'))

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="prevent-multiple-submits">
        @csrf

        @form_group([
            'type'        => "email",
            'name'        => "email",
            'text'        => __('addworking.user.auth.passwords.email.email_address'),
            'required'    => true,
            '_attributes' => ['autofocus' => true],
        ])

        @button(__('addworking.user.auth.passwords.email.send')."|type:submit")
    </form>
@endsection
