@extends('foundation::layout.app.index')

@section('title', __('enterprise.resource.application.views.activity_period.index.title')." {$activity_period->customer->name}")

@section('toolbar')

@endsection

@section('breadcrumb')
    {{ $activity_period->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('form')
    {{ $activity_period->views->filter }}
@endsection

@section('table.head')
    {{ $activity_period->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse($items as $activity_period)
        @can('show', $activity_period)
            @if($activity_period->resource->id)
                {{ $activity_period->views->table_row }}
            @endif
        @endcan
    @empty
        {{ $activity_period->views->table_row_empty }}
    @endforelse
@endsection

