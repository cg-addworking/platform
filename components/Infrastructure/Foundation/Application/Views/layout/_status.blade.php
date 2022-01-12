@php
    $class   = array_get(session('status'), 'class', 'primary');
    $message = is_array(session('status')) ? array_get(session('status'), 'message', '') : session('status');
    $info    = ['primary' => "Notice", 'danger' => "Danger !", 'warning' => "Attention !", 'success' => "Succès"][$class] ?? "Notice";
    $cta_icon     = array_get(session('cta'), "icon");
    $cta_text     = array_get(session('cta'),"text");
    $cta_href     = array_get(session('cta'), "href");
@endphp

<div class="alert alert-{{ $class }} alert-dismissible fade show mt-3" role="alert">
    <strong>{{ $info }}</strong> {{ $message }}
    @if(! empty($cta_text))
        @button($cta_text."|href:".$cta_href."|icon:".$cta_icon."|color:".$class."|outline|sm|mr:2")
    @endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
