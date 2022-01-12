@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.document.history.history')." : {$document_type->display_name} pour {$enterprise->name}")

@section('toolbar')
    @button(__('addworking.enterprise.document.history.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.history.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.history.company')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.history.document').'|href:'.route('addworking.enterprise.document.index', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.document.history.history').": ".$document_type->display_name."|active")
@endsection

@section('table.colgroup')
@endsection

@section('table.head')
    <th>UID</th>
    <th>{{ __('addworking.enterprise.document.history.service_provider') }}</th>
    <th>{{ __('addworking.enterprise.document.history.deposit_date') }}</th>
    <th>{{ __('addworking.enterprise.document.history.expiration_date') }}</th>
    <th class="text-center">{{ __('addworking.enterprise.document.history.status') }}</th>
    <th class="text-center">{{ __('addworking.enterprise.document.history.state') }}</th>
    <th>{{ __('addworking.enterprise.document.history.deletion_date') }}</th>
    <th class="text-right">Action</th>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @forelse ($items as $document)
        <tr>
            <td><span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $document->id }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ substr($document->id, 0, 8) }}</span></td>
            <td>{{ $document->enterprise->views->link }}</td>
            <td>@date($document->created_at)</td>
            <td>@date($document->valid_until)</td>
            <td class="text-center">
                {{ $document->views->status }}
            </td>
            <td class="text-center">
                @if(! is_null($document->deleted_at)) <span class="badge badge-pill badge-danger">{{ __('addworking.enterprise.document.history.deleted') }}</span> @else <span class="badge badge-pill badge-success">{{ __('addworking.enterprise.document.history.active') }}</span> @endif
            </td>
            <td>@date($document->deleted_at)</td>
            <td class="text-right">
                @can('show', $document)
                    @if(! is_null($document->deleted_at))
                        <a href="{{ route('addworking.enterprise.document.show_trashed', [$enterprise, $document]) }}" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
                    @else
                        <a href="{{ route('addworking.enterprise.document.show', [$enterprise, $document]) }}" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
                    @endif
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-5">
                {{ __('addworking.enterprise.document.history.no_result') }}
            </td>
        </tr>
    @endforelse
@endsection
