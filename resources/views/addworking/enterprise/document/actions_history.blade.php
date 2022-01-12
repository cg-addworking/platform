@inject('actionRepository', 'Components\Common\Common\Application\Repositories\ActionRepository')

@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.document.actions_history.history')." : {$document->documentType->display_name} pour {$enterprise->name}")

@section('toolbar')
    @button(__('addworking.enterprise.document.actions_history.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.actions_history.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.actions_history.company')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.actions_history.document').'|href:'.route('addworking.enterprise.document.index', $enterprise))
    @breadcrumb_item("{$document->documentType->display_name}|href:{$document->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.actions_history.history')."|active")
@endsection

@section('table.colgroup')
@endsection

@section('table.head')
    <th>{{__('addworking.enterprise.document.actions_history.action') }}</th>
    <th>{{__('addworking.enterprise.document.actions_history.date') }}</th>
    <th>{{__('addworking.enterprise.document.actions_history.created_by') }}</th>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @forelse ($items as $item)
        <tr>
            <td>{{ $item->getMessage() }}</td>
            <td>{{ $item->getCreatedAt() }}</td>
            <td>@if(is_null($item->getUser()) || $item->getUser()->isSupport()) {{ "AddWorking" }} @else {{$item->getUser()->getNameAttribute()}} @endif</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-5">
                {{ __('addworking.enterprise.document.actions_history.no_result') }}
            </td>
        </tr>
    @endforelse
@endsection
