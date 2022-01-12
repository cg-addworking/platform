@component('mail::message')
{{ __('addworking.emails.enterprise.document.outdated.hello') }}

{{ __('addworking.emails.enterprise.document.outdated.addworking_supports_guarantee') }}

@if(count($documents) > 1)
{{ __('addworking.emails.enterprise.document.outdated.inform_legal_text_plurial') }}
@else
{{ __('addworking.emails.enterprise.document.outdated.inform_legal_text_singular') }}
@endif

@foreach($documents as $document)
- {{ $document->documentType->display_name }} ({{ __('addworking.emails.enterprise.document.outdated.valid_until') }} @date($document->valid_until))
@endforeach

{{ __('addworking.emails.enterprise.document.outdated.update_on_account') }}

@component('mail::button', ['url' => document([])->enterprise()->associate($enterprise)->routes->index])
    {{ __('addworking.emails.enterprise.document.outdated.update_on_account_button') }}
@endcomponent

{{ __('addworking.emails.enterprise.document.outdated.cordially') }}

{{ __('addworking.emails.enterprise.document.outdated.team_signature') }}
@endcomponent
