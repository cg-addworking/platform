@component('mail::message')
{{ __('document::document_model.refused_document.greetings') }}

{{ __('document::document_model.refused_document.sentence_one', ['document_name' => $document_name, 'document_signatory' => $document_signatory]) }}

{{ __('document::document_model.refused_document.sentence_two') }}

<i><b>{!! $comment !!}</b></i>

{{ __('document::document_model.refused_document.thanks_you') }}

{{ __('document::document_model.refused_document.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('document::document_model.refused_document.consult_button') }}
@endcomponent
@endcomponent