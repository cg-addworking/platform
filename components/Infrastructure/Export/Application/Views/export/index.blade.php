@inject('exportRepository', 'Components\Infrastructure\Export\Application\Repositories\ExportRepository')
@extends('foundation::layout.app.index')

@section('title', __('common.infrastructure.export.application.views.export.index.title'))

@section('breadcrumb')
     @include('export::export._breadcrumb')
@endsection

@section('table.head')
    @include('export::export._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $export)
        @include('export::export._table_row')
    @endforeach
@endsection