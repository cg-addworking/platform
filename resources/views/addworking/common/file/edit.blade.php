@extends('foundation::layout.app.create', ['action' => $file->routes->update, 'method' => "put", 'enctype' => "multipart/form-data"])

@section('title', __('addworking.common.file.edit.edit_file')." {$file->basename}");

@section('toolbar')
    @button(__('addworking.common.file.edit.return')."|href:{$file->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.file.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.file.edit.files').'|href:'.route('file.index') )
    @breadcrumb_item($file->basename .'|href:'.route('file.show', $file) )
    @breadcrumb_item(__('addworking.common.file.edit.edit')."|active")
@endsection


@section('form')
    {{ $file->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.file.edit.register')."|type:submit|color:warning|shadow|icon:save")
    </div>
@endsection
