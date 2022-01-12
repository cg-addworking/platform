@extends('foundation::layout.app.edit', ['action' => $covid19_form_answer->routes->update])

@section('title', __('soprema.enterprise.covid19_form_answer.edit.edit')." $covid19_form_answer")

@section('toolbar')
    @button(__('soprema.enterprise.covid19_form_answer.edit.return')."|href:{$covid19_form_answer->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('soprema.enterprise.covid19_form_answer.edit.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $covid19_form_answer->routes->index }}">{{ __('soprema.enterprise.covid19_form_answer.edit.covid19_form_answer') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $covid19_form_answer->routes->show }}">{{ $covid19_form_answer }}</li>
    <li class="breadcrumb-item active">{{ __('soprema.enterprise.covid19_form_answer.edit.edit') }}</li>
@endsection

@section('content')
    {{ $covid19_form_answer->views->form }}

    @button(__('soprema.enterprise.covid19_form_answer.edit.save')."|icon:save|type:submit")
@endsection
