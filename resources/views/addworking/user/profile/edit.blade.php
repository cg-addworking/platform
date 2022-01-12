@extends('foundation::layout.app.create', ['action' => route('profile.update'), 'enctype' => 'multipart/form-data', 'method' => 'POST'])

@section('title', __('addworking.user.profile.edit.edit_profile').' ' . $user->name)

@section('toolbar')
    @button(__('addworking.user.profile.edit.edit_email')."|href:".route('profile.edit_email')."|icon:cog|color:outline-primary|outline|sm|ml:2")

    @button(__('addworking.user.profile.edit.change_password')."|href:".route('profile.edit_password')."|icon:cog|color:outline-danger|outline|sm|ml:2")

    @button(__('addworking.user.profile.edit.return')."|href:".route('profile')."|icon:arrow-left|color:secondary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.profile.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.profile.edit.profile').'|href:'.route('profile') )
    @breadcrumb_item(__('addworking.user.profile.edit.edit')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.profile.edit.profile_information') }}</legend>

        <div class="row">
            <div class="col-md-2">
                @form_group([
                    'type'     => "select",
                    'options'  => array_trans(array_mirror(user()::getAvailableGenders()), 'messages.gender.'),
                    'name'     => "gender",
                    'value'    => optional($user)->gender,
                    'text'     => __('profile.profile.edit_gender'),
                    'required' => true,
                ])
            </div>

            <div class="col-md-5">
                @form_group([
                    'type'     => "text",
                    'name'     => "firstname",
                    'value'    => old('firstname', $user->firstname),
                    'text'     => __('profile.profile.edit_firstname'),
                    'required' => true,
                ])
            </div>

            <div class="col-md-5">
                @form_group([
                    'type'     => "text",
                    'options'  => array_trans(array_mirror(user()::getAvailableGenders()), 'messages.gender.'),
                    'name'     => "lastname",
                    'value'    => old('lastname', $user->lastname),
                    'text'     => __('profile.profile.edit_lastname'),
                    'required' => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'type'     => "file",
                    'name'     => "picture",
                    'text'     => __('user.user.picture'),
                    'accept'      => '.png, .jpg, .jpeg',
                    'required' => false,
                ])
            </div>
        </div>

    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.user.profile.edit.record')."|type:submit|color:success|shadow|icon:edit")
    </div>
@endsection
