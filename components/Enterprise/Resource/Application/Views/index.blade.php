@extends('foundation::layout.app.index')

@section('title', __('enterprise.resource.application.views.index.title')." {$resource->enterprise->name}")

@section('toolbar')
    @can('create', $enterprise)
        @button(__('enterprise.resource.application.views.index.add')."|href:{$resource->routes->create}|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('form')
    {{ $resource->views->filter }}
@endsection

@section('table.head')
    {{ $resource->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse($items as $resource)
        @can('show', $resource)
            {{ $resource->views->table_row }}
        @endcan
    @empty
        {{ $resource->views->table_row_empty }}
    @endforelse
@endsection

