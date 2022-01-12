@extends('foundation::layout.app.index')

@section('title', "Documents types")

@section('toolbar')
    @button("Retour|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard') )
    @breadcrumb_item("Gestion des types de documents|active")
@endsection

@section('table.head')
    @th("Document|not_allowed")
    @th("Propriétaire|not_allowed")
    @th("Type|not_allowed")
    @th("Obligatoire|not_allowed|class:text-center")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @foreach ($items as $document_type)
        <tr>
            <td>{{ $document_type->views->link }}</td>
            <td>{{ $document_type->enterprise->views->link }}</td>
            <td>{{ __("document.type.{$document_type->type}") ?? 'n/a' }}</td>
            <td class="text-center">{{ $document_type->is_mandatory ? 'Oui': 'Non'}}</td>
            <td class="text-right">{{ $document_type->views->actions }}</td>
        </tr>
    @endforeach
@endsection
