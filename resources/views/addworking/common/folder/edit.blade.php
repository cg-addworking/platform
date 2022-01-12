@extends('foundation::layout.app.edit', ['action' => $folder->routes->update])

@section('title', __('addworking.common.folder.edit.edit')." $folder")

@section('toolbar')
    @button(__('addworking.common.folder.edit.return')."|href:{$folder->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.folder.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.folder.edit.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.edit.files')."|href:{$folder->routes->index}")
    @breadcrumb_item("{$folder}|href:{$folder->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.edit.edit')."|active")
@endsection

@section('form')
    {{ $folder->views->form }}

    <div class="text-right">
        @button(__('addworking.common.folder.edit.register')."|icon:save|type:submit|color:success|outline")
    </div>
@endsection
