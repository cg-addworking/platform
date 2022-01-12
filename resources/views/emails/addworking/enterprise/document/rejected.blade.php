@component('mail::message')
{{ __('emails.addworking.enterprise.document.rejected.greeting') }}

{{ __('emails.addworking.enterprise.document.rejected.addworking_supports_guarantee') }}

{{ __('emails.addworking.enterprise.document.rejected.inform_legal_text') }} <b>{{ $document->documentType->display_name }}</b> {{ __('emails.addworking.enterprise.document.rejected.show_non_compliance') }}

{{ __('emails.addworking.enterprise.document.rejected.pattern') }} : {{ $document->reason_for_rejection ?? 'n/a' }} <br>
@if(!is_null($comment))
{!! $comment->content !!}
@endif

{{ __('emails.addworking.enterprise.document.rejected.please_update_account') }}

@component('mail::button', ['url' => $url])
    {{ __('emails.addworking.enterprise.document.rejected.update_documents') }}
@endcomponent

{{ __('emails.addworking.enterprise.document.rejected.cordially') }}

@lang('messages.confirmation.signature', ['name' => config('app.name')])

@endcomponent
