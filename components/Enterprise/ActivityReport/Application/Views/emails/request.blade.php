@component('mail::message')
{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.hello') }}

{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.text_line1') }}

{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.text_line2') }} {{__('components.enterprise.activity_report.application.views.activity_report.months.'. $month)}} {{$year}}

@component('mail::button', ['url' => $url])
    {{ __('addworking.components.enterprise.activity_report.application.views.emails.request.submit_activity_report') }}
@endcomponent

{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.cordially') }}

{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.addworking_team') }}

@slot('subcopy')

{{ __('addworking.components.enterprise.activity_report.application.views.emails.request.text_line3') }}: {{ $url }}

@endslot

@endcomponent
