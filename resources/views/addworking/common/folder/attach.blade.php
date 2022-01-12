@extends('foundation::layout.app.create', ['action' => folder([])->routes->link(compact('enterprise'))])

@section('title', __('addworking.common.folder.attach.add_to_folder'))

@section('toolbar')
    @button(__('addworking.common.folder.attach.return')."|href:".folder([])->routes->index(compact('enterprise'))."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.folder.attach.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.folder.attach.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.attach.files')."|href:".folder([])->routes->index(compact('enterprise')))
    @breadcrumb_item(__('addworking.common.folder.attach.attach').'|active')
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.common.folder.attach.link_to_file') }}</legend>

        @component('bootstrap::form.group', ['text' => __('addworking.common.folder.attach.object_to_add_to_file')])
            <input type="hidden" name="item[id]" value="{{ $item->id }}">
            <span class="form-control">
                {{ $item->views->link }}
            </span>
        @endcomponent

        @form_group([
            'text'         => __('addworking.common.folder.attach.file'),
            'name'         => "folder.id",
            'type'         => "select",
            'options'      => $folders->pluck('display_name', 'id'),
            'required'     => true,
            'selectpicker' => count($folders) > 10,
            'search'       => count($folders) > 10,
        ])
    </fieldset>

    <div class="text-right">
        @button(__('addworking.common.folder.attach.register')."|icon:save|type:submit|color:success|outline")
    </div>
@endsection
