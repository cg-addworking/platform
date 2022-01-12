@extends('foundation::layout.app.index')

@section('title', __('addworking.common.passwork.index.passworks_catalogs'))

@section('toolbar')
    @can('create', [passwork(), $enterprise])
        @button(__('addworking.common.passwork.index.add')."|href:".route('addworking.common.enterprise.passwork.create', $enterprise)."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.passwork.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.passwork.index.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.passwork.index.passworks')."|active")
@endsection

@section('table.head')
    <th>{{ __('addworking.common.passwork.index.username') }}</th>
    <th>{{ __('addworking.common.passwork.index.owner') }}</th>
    <th>{{ __('addworking.common.passwork.index.client') }}</th>
    <th>{{ __('addworking.common.passwork.index.skills') }}</th>
    <th>{{ __('addworking.common.passwork.index.created_at') }}</th>
    <th class="text-right">{{ __('addworking.common.passwork.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $passwork)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#passwork-{{ $passwork->id }}">{{ $passwork->id }}</a></td>
            @if($passwork->user->exists)
                <td><a href="{{ route('user.show', $passwork->user) }}">{{ $passwork->user->name }}</a></td>
            @elseif($passwork->vendor->exists)
                <td><a href="{{ route('enterprise.show', $passwork->vendor) }}">{{ $passwork->vendor->name }}</a></td>
            @else
                <td>n/a</td>
            @endif
            <td><a href="{{ route('enterprise.show', $passwork->customer) }}" target="_blank">{{ $passwork->customer->name }}</a></td>
            <td><a href="{{ route('addworking.common.enterprise.passwork.edit', [$enterprise, $passwork]) }}">{{ count($passwork->skills) }}</a></td>
            <td>@datetime($passwork->created_at)</td>
            <td class="text-right">{{ $passwork->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="passwork-{{ $passwork->id }}">
            <td colspan="6" class="p-3">
                {{ $passwork->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
