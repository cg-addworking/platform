
@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.mission_tracking.index.mission_monitoring'))

@section('toolbar')
    @if(auth()->user()->enterprise->isCustomer())
        @button("Importer des lignes de suivi de mission|href:".route('tracking_line.import')."|icon:upload|color:outline-primary|outline|sm|mr:2")
    @endif
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission_tracking.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission_tracking.index.mission_monitoring')."|active")
@endsection

@section('table.head')
    @th(__('addworking.mission.mission_tracking.index.mission_number').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.mission').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.client').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.service_provider').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.start_date').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.end_date').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.status').'|not_allowed')
    @th(__('addworking.mission.mission_tracking.index.actions').'|not_allowed|class:text-right')</th>
@endsection

@section('table.filter')
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.number",
            'class' => "form-control-sm",
            'value' => request()->input('filter.number'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.mission",
            'class' => "form-control-sm",
            'value' => request()->input('filter.mission'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.customer",
            'class' => "form-control-sm",
            'value' => request()->input('filter.customer'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.vendor",
            'class' => "form-control-sm",
            'value' => request()->input('filter.vendor'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "date",
            'name'  => "filter.starts_at",
            'class' => "form-control-sm",
            'value' => request()->input('filter.starts_at'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "date",
            'name'  => "filter.ends_at",
            'class' => "form-control-sm",
            'value' => request()->input('filter.ends_at'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
          'type'    => "select",
          'options' => array_trans(array_mirror(mission_tracking()::getAvailableStatuses()), 'mission.tracking.' ),
          'value'   => request()->input('filter.status'),
          'name'    => "filter.status",
          'class'   => "form-control-sm"
        ])
        @endcomponent
    </td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $tracking)
        <tr>
            <td>{{ $tracking->mission->number }}</td>
            <td>{{ $tracking->mission->views->link }}</td>
            <td>{{ $tracking->mission->customer->name }}</td>
            <td>{{ $tracking->mission->vendor->name }}</td>
            <td>@date($tracking->milestone->starts_at)</td>
            <td>@date($tracking->milestone->ends_at)</td>
            <td>@include('addworking.mission.mission_tracking._status')</td>
            <td class="text-right">{{ $tracking->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection
