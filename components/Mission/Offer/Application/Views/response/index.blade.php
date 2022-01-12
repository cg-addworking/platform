@extends('foundation::layout.app.index')

@section('title', __('offer::response.index.title', ['label' => $offer->getLabel()]))

@section('toolbar')
    @button(__('offer::response.index.return')."|href:".route('sector.offer.show', $offer)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('offer::response._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('offer::response._filters')
@endsection

@section('table.head')
    @include('offer::response._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $response)
        @include('offer::response._table_row')
    @endforeach
@endsection