@extends('foundation::layout.app.index')

@section('title', "Avenants de {$contract_addendum->parent}")

@section('toolbar')
    @can('createAddendum', $contract_addendum->parent)
        @button(sprintf("Ajouter|href:%s|icon:plus|color:outline-success|outline|sm", $contract_addendum->routes->create))
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_addendum->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('table.head')
    {{ $contract_addendum->views->table_head }}
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $contract_addendum)
        @can('view', $contract_addendum)
            {{ $contract_addendum->views->table_row }}
        @endcan
    @empty
        {{ $contract_addendum->views->table_row_empty }}
    @endforelse
@endsection
