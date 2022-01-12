@extends('foundation::layout.app.index')

@section('title', __('addworking.common.job.index.job_catalog'))

@section('toolbar')
    @can('create', [job(), $enterprise])
        @button(__('addworking.common.job.index.add')."|href:".route('addworking.common.enterprise.job.create', $enterprise)."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.job.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.job.index.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.job.index.job')."|active")
@endsection

@section('table.head')
    <th>{{ __('addworking.common.job.index.last_name') }}</th>
    <th>{{ __('addworking.common.job.index.enterprises') }}</th>
    <th>{{ __('addworking.common.job.index.skills') }}</th>
    <th>{{ __('addworking.common.job.index.created_at') }}</th>
    <th class="text-right">{{ __('addworking.common.job.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $job)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#job-{{ $job->id }}">{{ $job->display_name }}</a></td>
            <td><a href="{{ route('enterprise.show', $job->enterprise) }}">{{ $job->enterprise->name }}</a></td>
            <td><a href="{{ route('addworking.common.enterprise.job.skill.index', [$enterprise, $job]) }}">{{ count($job->skills) }}</a></td>
            <td>@datetime($job->created_at)</td>
            <td class="text-right">{{ $job->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="job-{{ $job->id }}">
            <td colspan="5" class="p-3">
                {{ $job->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
