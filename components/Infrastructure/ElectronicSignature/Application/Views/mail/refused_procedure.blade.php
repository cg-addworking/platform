<center><img src="{{ env('APP_URL') }}/img/logo_addworking_vertical.png" width="45%"></center>
<p>
    {{ __('components.infrastructure.electronic_signature.application.views.mail.refused_procedure.sentence_one', [], $language)}} <tag data-tag-type="string" data-tag-name="recipient.firstname"></tag> <tag data-tag-type="string" data-tag-name="recipient.lastname"></tag>,
</p>
<p>
    {{ __('components.infrastructure.electronic_signature.application.views.mail.refused_procedure.sentence_two', [], $language)}}
</p>
<p>
    <br>
    <center><a href="{{ $url }}"><button>{{ __('components.infrastructure.electronic_signature.application.views.mail.refused_procedure.sentence_three', [], $language)}}</button></a></center>
    <br><br>
</p>
<p>
    {{ __('components.infrastructure.electronic_signature.application.views.mail.refused_procedure.sentence_four', [], $language)}}
    <br>
    {{ __('components.infrastructure.electronic_signature.application.views.mail.refused_procedure.sentence_five', [], $language)}}
</p>