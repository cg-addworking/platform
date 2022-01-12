@extends('foundation::layout.app.index')

@section('title', __('edenred.common.code.index.code_catalog'))

@section('toolbar')
    @can('create', edenred_code())
        @button(__('edenred.common.code.index.add')."|href:".route('edenred.common.code.create')."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.code.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.code.index.codes')."|active")
@endsection

@section('table.head')
    <th>{{ __('edenred.common.code.index.code') }}</th>
    <th>{{ __('edenred.common.code.index.job') }}</th>
    <th>{{ __('edenred.common.code.index.skill') }}</th>
    <th>{{ __('edenred.common.code.index.providers') }}</th>
    <th>{{ __('edenred.common.code.index.created_at') }}</th>
    <th class="text-right">{{ __('edenred.common.code.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $code)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#code-{{ $code->id }}">{{ $code->label }}</a></td>
            <td><a href="{{ route('addworking.common.enterprise.job.show', [$code->skill->job->enterprise, $code->skill->job]) }}">{{ $code->skill->job->display_name }}</a></td>
            <td><a href="{{ route('addworking.common.enterprise.job.skill.show', [$code->skill->job->enterprise, $code->skill->job, $code->skill]) }}">{{ $code->skill->display_name }}</a></td>
            <td><a href="{{ route('edenred.common.code.average_daily_rate.index', $code) }}">{{ count($code->averageDailyRates) }}</a></td>
            <td>@datetime($code->created_at)</td>
            <td class="text-right">{{ $code->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="code-{{ $code->id }}">
            <td colspan="7" class="p-3">
                {{ $code->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
