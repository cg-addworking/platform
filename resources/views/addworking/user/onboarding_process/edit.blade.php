@extends('foundation::layout.app.edit', ['action' => route('support.user.onboarding_process.update', $onboarding_process)])

@section('title', __('addworking.user.onboarding_process.edit.edit_onboarding_process'))

@section('toolbar')
    @button(__('addworking.user.onboarding_process.edit.return')."|href:".route('support.user.onboarding_process.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.onboarding_process.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.onboarding_process.edit.onboarding_process').'|href:'.route('support.user.onboarding_process.index') )
    @breadcrumb_item(__('addworking.user.onboarding_process.edit.edit')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.onboarding_process.edit.general_information') }}</legend>

        <input type="hidden" name="onboarding_process[id]" value="{{ $onboarding_process->id }}">
        <input type="hidden" name="onboarding_process[user]" value="{{ $onboarding_process->user->id }}">
        <input type="hidden" name="onboarding_process[enterprise]" value="{{ $onboarding_process->enterprise->id }}">

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'       => __('addworking.user.onboarding_process.edit.onboarding_completed'),
                    'horizontal'  => true,
                    'required'    => true,
                    'type'        => "select",
                    'name'        => "onboarding_process.complete",
                    'value'       => $onboarding_process->complete,
                    'options'      => [1 => 'Oui', 0 => 'Non'],
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'       => __('addworking.user.onboarding_process.edit.step_in_process'),
                    'horizontal'  => true,
                    'required'    => true,
                    'type'        => "select",
                    'name'        => "onboarding_process.current_step",
                    'value'       => $onboarding_process->current_step,
                    'options'     => $onboarding_process->steps->map(function ($step) {
                        return $step->getDisplayName();
                    }),
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.user.onboarding_process.edit.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
