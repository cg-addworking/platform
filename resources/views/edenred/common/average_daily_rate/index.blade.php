@extends('foundation::layout.app.index')

@section('title', __('edenred.common.average_daily_rate.index.average_daily_rates_for')." {$code->code}")

@section('toolbar')
    @can('create', edenred_average_daily_rate())
        @button(__('edenred.common.average_daily_rate.index.add')."|href:".route('edenred.common.code.average_daily_rate.create', $code)."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.average_daily_rate.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.average_daily_rate.index.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item($code->code .'|href:'.route('edenred.common.code.show', $code) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.index.average_daily_rate')."|active")
@endsection

@section('table.head')
    <th>{{ __('edenred.common.average_daily_rate.index.service_provider') }}</th>
    <th>{{ __('edenred.common.average_daily_rate.index.rate') }}</th>
    <th>{{ __('edenred.common.average_daily_rate.index.created_at') }}</th>
    <th class="text-right">{{ __('edenred.common.average_daily_rate.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $average_daily_rate)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#vendor-{{ $average_daily_rate->vendor->id }}">{{ $average_daily_rate->vendor->name }}</a></td>
            <td>{{ $average_daily_rate->rate }}</td>
            <td>@datetime($average_daily_rate->created_at)</td>
            <td class="text-right">{{ $average_daily_rate->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="vendor-{{ $average_daily_rate->vendor->id }}">
            <td colspan="7" class="p-3">
                {{ $average_daily_rate->vendor->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
