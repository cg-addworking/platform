@extends('foundation::layout.app.show')

@section('title', __('addworking.common.folder.index.files'))

@section('toolbar')
    @can('create', [folder(), $enterprise])
        @button(sprintf(__('addworking.common.folder.index.add')."|href:%s|icon:plus|color:outline-success|outline|sm", folder([])->routes->create(compact('enterprise'))))
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.folder.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.folder.index.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.index.files')."|active")
@endsection

@section('tabs')
        <a class="nav-item nav-link active" id="nav-own-folder-tab" data-toggle="tab" href="#nav-own-folder" role="tab" aria-controls="nav-own-folder" aria-selected="true">{{ __('addworking.common.folder.index.my_folders') }}</a>
        <a class="nav-item nav-link" id="nav-customer-folder-tab" data-toggle="tab" href="#nav-customer-folder" role="tab" aria-controls="nav-customer-folder" aria-selected="true">{{ __('addworking.common.folder.index.my_clients_files') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade active show" id="nav-own-folder" role="tabpanel" aria-labelledby="nav-own-folder-tab">
        <table class="table table-hover">
            <colgroup>
                <col width="20%">
                <col width="25%">
                <col width="20%">
                <col width="25%">
                <col width="10%">
            </colgroup>

            <thead>
                @th(__('addworking.common.folder.index.created_at').'|column:created_at')
                @th(__('addworking.common.folder.index.file').'|column:display_name')
                @th(__('addworking.common.folder.index.owner').'|not_allowed')
                @th(__('addworking.common.folder.index.enterprises').'|not_allowed')
                @th(__('addworking.common.folder.index.actions').'|not_allowed|class:text-right')
            </thead>

            <tbody>
                <tr>
                    @forelse ($items as $folder)
                        <tr>
                            <td>@date($folder->created_at)</td>
                            <td>{{ $folder->display_name }}</td>
                            <td>{{ $folder->createdBy->views->link }}</td>
                            <td>{{ $folder->enterprise->views->link }}</td>
                            <td class="text-right">{{ $folder->views->actions }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="999">@lang('messages.empty')</td>
                        </tr>
                    @endforelse
                </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-customer-folder" role="tabpanel" aria-labelledby="nav-customer-folder-tab">
        <table class="table table-hover">
            <colgroup>
                <col width="20%">
                <col width="25%">
                <col width="20%">
                <col width="25%">
                <col width="10%">
            </colgroup>

            <thead>
                @th(__('addworking.common.folder.index.created_at').'|column:created_at')
                @th(__('addworking.common.folder.index.file').'|column:display_name')
                @th(__('addworking.common.folder.index.owner').'|not_allowed')
                @th(__('addworking.common.folder.index.enterprises').'|not_allowed')
                @th(__('addworking.common.folder.index.actions').'|not_allowed|class:text-right')
            </thead>

            <tbody>
                <tr>
                    @forelse ($customerItems as $folder)
                        <tr>
                            <td>@date($folder->created_at)</td>
                            <td>{{ $folder->display_name }}</td>
                            <td>{{ $folder->createdBy->views->link }}</td>
                            <td>{{ $folder->enterprise->views->link }}</td>
                            <td class="text-right">{{ $folder->views->actions }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="999">@lang('messages.empty')</td>
                        </tr>
                    @endforelse
                </tr>
            </tbody>
        </table>
    </div>
@endsection