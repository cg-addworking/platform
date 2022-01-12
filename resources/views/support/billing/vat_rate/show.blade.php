@extends('foundation::layout.app.show')

@section('title', $vat_rate->display_name)

@section('toolbar')
    @button("Retour|href:{$vat_rate->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $vat_rate->views->actions }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ $vat_rate->routes->index }}">Taux TVA</a></li>
    <li class="breadcrumb-item active">{{ $vat_rate->display_name }}</li>
@endsection

@section('content')
    {{ $vat_rate->views->html }}
@endsection
