@extends('foundation::layout.app.create', ['action' => route('edenred.common.code.store')])

@section('title', __('edenred.common.code.create.create_new_code'));

@section('toolbar')
    @button(__('edenred.common.code.create.return')."|href:".route('edenred.common.code.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.code.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.code.create.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item(__('edenred.common.code.create.create_code')."|active")
@endsection

@section('form')
    {{ $code->views->form }}

    <div class="text-right my-5">
        @button(__('edenred.common.code.create.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
