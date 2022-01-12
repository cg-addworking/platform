@inject('annexRepository', 'Components\Contract\Contract\Application\Repositories\AnnexRepository')

@extends('foundation::layout.app.index')

@section('title', __('components.contract.contract.application.views.annex.index.title'))

@section('toolbar')
    @can('create',get_class($annexRepository->make()))
        @button(__('components.contract.contract.application.views.annex.index.create')."|href:".route('support.annex.create')."|icon:plus|color:success|outline|sm|mr:2")
    @endcan

    @button(__('components.contract.contract.application.views.contract.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")

@endsection

@section('breadcrumb')
    @include('contract::annex._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('contract::annex._filters')
@endsection

@section('table.head')
    @include('contract::annex._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $annex)
        @include('contract::annex._table_row')
    @endforeach
@endsection