@extends('foundation::layout.app.create', ['action' => $folder->routes->store])

@section('title', __('addworking.common.folder.create.create_folder'))

@section('toolbar')
    @button(__('addworking.common.folder.create.return')."|href:{$folder->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.folder.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.folder.create.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.create.files')."|href:{$folder->routes->index}")
    @breadcrumb_item(__('addworking.common.folder.create.create').'|active')
@endsection

@section('form')
    {{ $folder->views->form }}

    <div class="text-right">
        @button(__('addworking.common.folder.create.register')."|icon:save|type:submit|color:success|outline")
    </div>
@endsection
