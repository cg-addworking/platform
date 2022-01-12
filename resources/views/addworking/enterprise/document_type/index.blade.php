@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.document_type.index.document_list')." ".$enterprise->name)

@section('toolbar')
    @button(__('addworking.enterprise.document_type.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.enterprise.document_type.index.add')."|href:{$document_type->routes->create}|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document_type.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document_type.index.document_type_management')."|active")
@endsection

@section('table.head')
    @th("Document|not_allowed")
    @th("Type|not_allowed")
    @th(__('addworking.enterprise.document_type.index.mandatory')."|not_allowed")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @foreach ($items as $type)
        <tr>
            <td>{{ $type->views->link }}</td>
            <td>{{ $type->views->type }}</td>
            <td>@bool($type->is_mandatory)</td>
            <td class="text-right">{{ $type->views->actions }}</td>
        </tr>
    @endforeach
@endsection
