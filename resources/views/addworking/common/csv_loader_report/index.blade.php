@extends('foundation::layout.app.index')

@section('title', __('addworking.common.csv_loader_report.index.csv_load_reports'))

@section('toolbar')
    @can('create', csv_loader_report())
        @button(sprintf(__('addworking.common.csv_loader_report.index.add') ."|href:%s|icon:plus|color:outline-success|outline|sm", csv_loader_report([])->routes->create))
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.csv_loader_report.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.csv_loader_report.index.csv_load_reports')."|active")
@endsection

@section('table.head')
    @th(__('addworking.common.csv_loader_report.index.date')."|column:created_at")
    @th(__('addworking.common.csv_loader_report.index.label')."|column:label")
    @th(__('addworking.common.csv_loader_report.index.number_of_lines')."|column:line_count|class:text-right")
    @th(__('addworking.common.csv_loader_report.index.errors')."|column:error_count|class:text-right")
    @th(__('addworking.common.csv_loader_report.index.actions')."|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $csv_loader_report)
        <tr>
            <td>@date($csv_loader_report->created_at)</td>
            <td>{{ $csv_loader_report->label }}</td>
            <td class="text-right">{{ $csv_loader_report->line_count }}</td>
            <td class="text-right">{{ $csv_loader_report->error_count }} (@percentage($csv_loader_report->error_rate))</td>
            <td class="text-right">{{ $csv_loader_report->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
