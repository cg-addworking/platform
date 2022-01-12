@component('mail::message')
{{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.greetings', ['user_name' => $user_name]) }}

{{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.sentence_one', ['contract_name' => $contract_name]) }}

<i><b>{!! $comment_content !!}</b></i>

{{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.comment_author', ['author_name' => $author_name]) }}

{{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.thanks_you') }}

{{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.addworking_team') }}

@component('mail::button', ['url' => $url])
    {{ __('components.contract.contract.application.views.contract.mail.notify_for_new_comment.consult_button') }}
@endcomponent
@endcomponent
