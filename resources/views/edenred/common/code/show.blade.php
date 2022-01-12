@extends('foundation::layout.app.show')

@section('title', "Code {$code->code}")

@section('toolbar')
    @button("Retour|href:".route('edenred.common.code.index')."|icon:arrow-left|color:secondary|outline|sm")
    {{ $code->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item("Tableau de bord|href:".route('dashboard'))
    @breadcrumb_item('Codes|href:'.route('edenred.common.code.index') )
    @breadcrumb_item($code->code ."|active")
@endsection

@section('content')
    {{ $code->views->html }}
@endsection
