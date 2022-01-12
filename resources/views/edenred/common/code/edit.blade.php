@extends('foundation::layout.app.edit', ['action' => route('edenred.common.code.update', $code)])

@section('title', __('edenred.common.code.edit.edit_code')." {$code->code}");

@section('toolbar')
    @button(__('edenred.common.code.edit.return')."|href:".route('edenred.common.code.show', $code)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.code.edit.dashboard').'|href:'.route('dashboard') )
    @breadcrumb_item(__('edenred.common.code.edit.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item("{$code->code}|href:{$code->routes->show}")
    @breadcrumb_item(__('edenred.common.code.edit.edit')."|active")
@endsection

@section('form')
    {{ $code->views->form }}

    <div class="text-right my-5">
        @button(__('edenred.common.code.edit.register')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
