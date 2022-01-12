@component('mail::message')

{{ __('emails.sogetrel.passwork.search.notification.hello') }},

{{ __('emails.sogetrel.passwork.search.notification.your_research') }} <b>"{{ $schedule->passworkSavedSearch->name }}"</b> {{ __('emails.sogetrel.passwork.search.notification.saved_returned') }} {{ count($passworks) }} {{ __('emails.sogetrel.passwork.search.notification.results') }}

@if($passworks->count() > 0)
    {{ __('emails.sogetrel.passwork.search.notification.extract_of_results') }} :
    @foreach ($passworks as $passwork)

        -{{ __('emails.sogetrel.passwork.search.notification.service_provider') }} : {{ $passwork->user->name ?? 'n/a' }}
        -{{ __('emails.sogetrel.passwork.search.notification.enterprise') }} : {{ array_get($passwork->data, 'enterprise_name') ?: 'n/a' }}
        -{{ __('emails.sogetrel.passwork.search.notification.no_of_employees') }} : {{ array_get($passwork->data, 'enterprise_number_of_employees') ?: 'n/a' }}
        -{{ __('emails.sogetrel.passwork.search.notification.electrician') }} : {{ array_get($passwork->data, 'electrician') ? __('emails.sogetrel.passwork.search.notification.yes') : __('emails.sogetrel.passwork.search.notification.no') }}
        -{{ __('emails.sogetrel.passwork.search.notification.technician') }} : {{ array_get($passwork->data, 'multi_activities') ?  __('emails.sogetrel.passwork.search.notification.yes') : __('emails.sogetrel.passwork.search.notification.no') }}
        -{{ __('emails.sogetrel.passwork.search.notification.engineering_office') }}  : {{ array_get($passwork->data, 'engineering_office') ? __('emails.sogetrel.passwork.search.notification.yes') : __('emails.sogetrel.passwork.search.notification.no') }}
        -{{ __('emails.sogetrel.passwork.search.notification.civil_engineering') }}  : {{ array_get($passwork->data, 'civil_engineering') ? __('emails.sogetrel.passwork.search.notification.yes') : __('emails.sogetrel.passwork.search.notification.no') }}
        -{{ __('emails.sogetrel.passwork.search.notification.departments') }} : @include('emails.sogetrel.passwork.search._departments')
        ________________________________________________________________________
        @if ($loop->iteration > 10)
            @break
        @endif
    @endforeach
@endif

@component('mail::button', ['url' => $url . "?" . $schedule->passworkSavedSearch->getQueryStringAttribute()])
    {{ __('emails.sogetrel.passwork.search.notification.see_all_results') }}
@endcomponent

{{ __('emails.sogetrel.passwork.search.notification.best_regards') }},

{{ __('emails.sogetrel.passwork.search.notification.addworking_team') }}
@endcomponent
