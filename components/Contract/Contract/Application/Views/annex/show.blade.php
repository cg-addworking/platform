@extends('foundation::layout.app.show')

@section('title', $annex->getName())

@section('toolbar')
    @button(__('components.contract.contract.application.views.annex.show.return')."|href:".route('support.annex.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('contract::annex._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('contract::annex._html')
@endsection
