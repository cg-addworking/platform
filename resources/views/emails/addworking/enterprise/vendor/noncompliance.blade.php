@inject('enterpriseRepository', 'App\Repositories\Addworking\Enterprise\EnterpriseRepository')

@component('mail::message')
{{ __('addworking.emails.enterprise.vendor.noncompliance.hello') }}

{{ __('addworking.emails.enterprise.vendor.noncompliance.addworking_supports_guarantee') }}

{{ __('addworking.emails.enterprise.vendor.noncompliance.inform_legal_text_plural') }}

@if(!empty($non_compliant_vendors))
<ul>
    @foreach ($non_compliant_vendors as $vendor)
    <li><a href="{{ route('addworking.enterprise.document.index', $vendor) }}">{{ $vendor->name }}</a></li>
    @endforeach
</ul>
<br>
@endif

<p>{{ __('addworking.emails.enterprise.vendor.noncompliance.reminder_compliance_email') }}</p>
<br>
@component('mail::button', ['url' => route('addworking.enterprise.vendor.index', $customer)])
    {{ __('addworking.emails.enterprise.vendor.noncompliance.log_in') }}
@endcomponent


<br>
<br>
{{ __('addworking.emails.enterprise.vendor.noncompliance.cordially') }}

{{ __('addworking.emails.enterprise.vendor.noncompliance.compliance_service') }}
@endcomponent
