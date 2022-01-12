@extends('foundation::layout.app.create', ['action' => route('terms_of_use.accepted')])

@section('title', __('addworking.user.terms_of_use.show.accept_general_condition'))

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.terms_of_use.show.general_information') }}</legend>

        @include("terms_of_use")
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @form_group([
                    'type'     => "checkbox",
                    'name'     => "tos_accepted",
                    'text'     => __('user.register.accept_tou') .' '. strtolower(__('messages.terms_of_use')),
                    'required' => true,
                    'inline'   => true,
                    'class'    => 'font-weight-bold',
                    '_attributes' => [
                        'required' => 'required',
                    ]
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-center my-2">
        @button(__('addworking.user.terms_of_use.show.validate')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
