@extends('foundation::layout.app.index')

@section('title', "Échéance de paiement")

@section('toolbar')
    @button(sprintf("Ajouter|href:%s|icon:plus|color:outline-success|outline|sm", deadline_type([])->routes->create))
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard'))
    @breadcrumb_item("Échéance de paiement|active")
@endsection

@section('table.head')
    @th("Label|not_allowed")
    @th("Jours|not_allowed")
    @th("Description|not_allowed")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $deadline_type)
        <tr>
            <td>{{ $deadline_type->display_name }}</td>
            <td>{{ $deadline_type->value }}</td>
            <td>{{ $deadline_type->description }}</td>
            <td class="text-right">{{ $deadline_type->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
