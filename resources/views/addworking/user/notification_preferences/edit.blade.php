@extends('layouts.app')

@section('id', 'addworking-user-notification-preferences-edit')

@section('title')
    @component('components.panel')
        <h1 class="mb-0">{{ __('addworking.user.notification_process.edit.notification_setting') }}</h1>
    @endcomponent
@endsection

@section('content')
    <form action="{{ route('addworking.user.notification_preferences.update', $notification_preferences) }}"  method="post" class="form form-horizontal">
        @csrf
        @method('put')
        @include('_form_errors')

        @component('components.panel')
            @form_group([
                'horizontal' => true,
                'type'       => "select",
                'text'       => __('addworking.user.notification_process.edit.receive_emails'),
                'options'    => [1 => "Oui", 0 => "Non"],
                'value'      => (int) $notification_preferences->email_enabled,
                'name'       => 'notification_preferences.email_enabled',
            ])

            @form_group([
                'horizontal' => true,
                'type'       => "select",
                'text'       => __('addworking.user.notification_process.edit.notify_service_provider_paid'),
                'options'    => [1 => "Oui", 0 => "Non"],
                'value'      => (int) $notification_preferences->confirmation_vendors_are_paid,
                'name'       => 'notification_preferences.confirmation_vendors_are_paid',
            ])

            @form_group([
                'horizontal' => true,
                'type'       => "select",
                'text'       => __('addworking.user.notification_process.edit.iban_change_confirmation'),
                'options'    => [1 => "Oui", 0 => "Non"],
                'value'      => (int) $notification_preferences->iban_validation,
                'name'       => 'notification_preferences.iban_validation',
            ])

            @form_group([
                'horizontal' => true,
                'type'       => "select",
                'text'       => __('addworking.user.notification_process.edit.receive_mission_followup_email'),
                'options'    => [1 => "Oui", 0 => "Non"],
                'value'      => (int) $notification_preferences->mission_tracking_created,
                'name'       => 'notification_preferences.mission_tracking_created',
            ])

            <div class="text-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
            </div>
        @endcomponent
    </form>
@endsection
