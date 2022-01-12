@extends('foundation::layout.app.index')

@section('title', __('sogetrel_passwork::acceptation.index.title'))

@section('toolbar')
    @button(__('work_field::workfield.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
     @include('sogetrel_passwork::acceptation._breadcrumb')
@endsection

@section('filters')
    @include('sogetrel_passwork::acceptation._filters')
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="20%">
    <col width="15%">
    <col width="14%">
    <col width="12%">
    <col width="12%">
    <col width="7%">
    <col width="7%">
    <col width="7%">
    <col width="7%">
    <col width="7%">
    <col width="7%">
    <col width="7%">
@endsection

@section('table.head')
    @include('sogetrel_passwork::acceptation._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $acceptation)
        @include('sogetrel_passwork::acceptation._table_row')
    @endforeach
@endsection
