@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.vendor.index_division_by_skills.title'))

@section('toolbar')
    @button(__('addworking.enterprise.vendor.index_division_by_skills.return_button')."|href:".route('addworking.enterprise.vendor.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.enterprise.vendor.index_division_by_skills.jobs_catalog_button')."|href:".route('addworking.common.enterprise.job.index', $enterprise)."|icon:user|color:outline-primary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.vendor.index_division_by_skills.breadcrumb.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $enterprise->routes->index }}">{{ __('addworking.enterprise.vendor.index_division_by_skills.breadcrumb.enterprise') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $enterprise->routes->show }}">{{ $enterprise->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('addworking.enterprise.vendor.index', $enterprise) }}">{{ __('addworking.enterprise.vendor.index_division_by_skills.breadcrumb.my_vendors') }}</a></li>
    <li class="breadcrumb-item active">{{ __('addworking.enterprise.vendor.index_division_by_skills.breadcrumb.division_by_skills') }}</li>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.colgroup')
    <col width="45%">
    <col width="40%">
    <col width="25%">
@endsection

@section('table.head')
    @include('addworking.enterprise.vendor.division_by_skills._table_head')
@endsection

@section('table.body')
    @forelse ($items as $skill)
        @include('addworking.enterprise.vendor.division_by_skills._table_row')
    @empty
        @include('addworking.enterprise.vendor.division_by_skills._table_row_empty')
    @endforelse
@endsection