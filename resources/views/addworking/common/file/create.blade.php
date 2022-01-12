@extends('foundation::layout.app.create', ['action' => $file->routes->store, 'enctype' => "multipart/form-data"])

@section('title', __('addworking.common.file.create.create_file'));

@section('toolbar')
    @button(__('addworking.common.file.create.return')."|href:{$file->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.file.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.file.create.files').'|href:'.$file->routes->index )
    @breadcrumb_item(__('addworking.common.file.create.create')."|active")
@endsection

@section('form')
    @yield('form.hidden')

    {{ $file->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.file.create.register')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
