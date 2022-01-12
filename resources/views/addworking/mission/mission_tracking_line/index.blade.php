
@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.mission_tracking_line.index.title'))

@section('toolbar')
    @can('create', [get_class($mission_tracking_line), $mission_tracking_line->missionTracking])
        @button(__('messages.create')."|href:{$mission_tracking_line->routes->create}")
    @endcan
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $mission_tracking_line->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $mission_tracking_line)
        {{ $mission_tracking_line->views->table_row }}
    @empty
        {{ $mission_tracking_line->views->table_row_empty }}
    @endforelse
@endsection
