@extends('foundation::layout.app.show')

@section('title', "$covid19_form_answer")

@section('toolbar')
    @button(__('soprema.enterprise.covid19_form_answer.show.return')."|href:{$covid19_form_answer->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $covid19_form_answer->views->actions }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('soprema.enterprise.covid19_form_answer.show.dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('soprema.enterprise.covid19_form_answer.show.soprema') }}</li>
    <li class="breadcrumb-item"><a href="{{ $covid19_form_answer->routes->index }}">{{ __('soprema.enterprise.covid19_form_answer.show.covid19_form_answer') }}</a></li>
    <li class="breadcrumb-item active">{{ "$covid19_form_answer" }}</li>
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('soprema.enterprise.covid19_form_answer.show.general_information') }}</a>
    <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#nav-message" role="tab" aria-controls="nav-message" aria-selected="true">{{ __('soprema.enterprise.covid19_form_answer.show.message') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        {{ $covid19_form_answer->views->html }}
    </div>
    <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">
        {{ html_string(nl2br($covid19_form_answer->message)) }}
    </div>
@endsection
