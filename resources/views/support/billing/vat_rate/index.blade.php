@extends('foundation::layout.app.index')

@section('title', "Taux de TVA")

@section('toolbar')
    @button(sprintf("Ajouter|href:%s|icon:plus|color:outline-success|outline|sm", vat_rate([])->routes->create))
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item active">Taux TVA</li>
@endsection

@section('table.head')
    @th("Label|not_allowed")
    @th("Valeur|not_allowed")
    @th("Description|not_allowed")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $vat_rate)
        <tr>
            <td>{{ $vat_rate->display_name }}</td>
            <td>@percentage($vat_rate->value)</td>
            <td>{{ $vat_rate->description }}</td>
            <td class="text-right">{{ $vat_rate->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
