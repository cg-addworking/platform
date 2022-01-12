@extends('foundation::layout.app.index')

@section('title', __('addworking.common.skill.index.job_skills') ." {$job->display_name}")

@section('toolbar')
    @can('create', [skill(), $job])
        @button(__('addworking.common.skill.index.add')."|href:".route('addworking.common.enterprise.job.skill.create', [$enterprise, $job])."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.skill.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.skill.index.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.index.job')."|href:{$job->routes->index}")
    @breadcrumb_item("{$job->display_name}|href:{$job->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.index.skills')."|active")
@endsection

@section('table.head')
    <th>{{ __('addworking.common.skill.index.skills') }}</th>
    <th>{{ __('addworking.common.skill.index.created_at') }}</th>
    <th class="text-right">{{ __('addworking.common.skill.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $skill)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#skill-{{ $skill->id }}">{{ $skill->display_name }}</a></td>
            <td>@datetime($skill->created_at)</td>
            <td class="text-right">{{ $skill->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="skill-{{ $skill->id }}">
            <td colspan="6" class="p-3">
                {{ $skill->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
