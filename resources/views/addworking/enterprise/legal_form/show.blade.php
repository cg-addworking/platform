@extends('foundation::layout.app.show')

@section('title', $legal_form->display_name)

@section('toolbar')
    @button(__('addworking.enterprise.legal_form.show.return')."|href:{$legal_form->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $legal_form->views->actions }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.legal_form.show.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $legal_form->routes->index }}">{{ __('addworking.enterprise.legal_form.show.legal_form') }}</a></li>
    <li class="breadcrumb-item active">{{ $legal_form->display_name }}</li>
@endsection

@section('content')
    {{ $legal_form->views->html }}
@endsection
