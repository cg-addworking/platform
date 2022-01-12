@extends('foundation::layout.app.edit', ['action' => route('profile.save_email'), 'method' => 'POST'])

@section('title', __('profile.profile.edit_email_title'))

@section('toolbar')
    @button("Retour|href:".route('profile')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.profile.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.profile.edit.profile').'|href:'.route('profile') )
    @breadcrumb_item(__('addworking.user.profile.edit.edit_email')."|active")
@endsection

@section('form')
    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'     => __('profile.profile.edit_email_new_email'),
                'type'     => "email",
                'name'     => "email",
                'placeholder'    => $user->email,
                'required' => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
            'text'        => __('profile.profile.edit_email_password'),
            'type'        => "password",
            'name'        => "password",
            'placeholder' => "nouveau mot de passe",
            'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'     => __('profile.profile.edit_email_password_repeat'),
                'type'     => "password",
                'name'     => "password_confirmation",
                'placeholder' => "confirmer le nouveau mot de passe",
                'required' => true,
            ])
        </div>
    </div>
    <br>
    @button(__('messages.save')."|icon:check|type:submit|color:success")
@endsection

