@extends('foundation::layout.app.index')

@section('title', __('offer::offer.index.title'))

@section('toolbar')
    @button(__('offer::offer.index.return')."|href:".route('sector.offer.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('offer::offer._breadcrumb', ['page' => "index"])
@endsection

@section('form')
    @include('offer::offer._filters')
@endsection

@section('table.head')
    @include('offer::offer._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $offer)
        @include('offer::offer._table_row')
    @endforeach
@endsection
