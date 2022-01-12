@inject('workFieldRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository')

@extends('foundation::layout.app.index')

@section('title', __('work_field::workfield.index.title'))

@section('toolbar')
    @can('create', get_class($workFieldRepository->make()))
        @button(__('work_field::workfield.index.create')."|href:".route('work_field.create')."|icon:list-alt|color:success|outline|sm|mr:2")
    @endcan
    @button(__('work_field::workfield.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
     @include('work_field::work_field._breadcrumb')
@endsection

@section('form')
    @include('work_field::work_field._filters')
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="20%">
    <col width="15%">
    <col width="14%">
    <col width="12%">
    <col width="12%">
    <col width="7%">
@endsection

@section('table.head')
    @include('work_field::work_field._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $work_field)
        @include('work_field::work_field._table_row')
    @endforeach
@endsection