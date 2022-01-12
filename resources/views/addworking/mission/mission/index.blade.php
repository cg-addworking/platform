@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.mission.index.mission'))

@section('toolbar')
    @button(__('addworking.mission.mission.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('create', mission())
        @button(__('addworking.mission.mission.index.add')."|href:".route('mission.create')."|icon:plus|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission.index.mission')."|active")
@endsection

@can('seeMyVendors', Auth::user()->enterprise)
@section('table.filter')
    @parent
    @form_control([
    'class'       => "pb-2",
    'text'        => "Voir uniquement mes prestataires attribués",
    'type'        => "switch",
    'name'        => "show-my-vendors",
    '_attributes' => ['onChange' => "this.form.submit()"] + (request()->has('show-my-vendors') ? ['checked' => 'checked'] : []),
    ])
@endsection
@endcan

@section('table.colgroup')
    <col width="2%">
    <col width="5%">
    <col width="15%">
    <col width="20%">
    <col width="5%">
    <col width="15%">
    <col width="8%">
    <col width="7%">
    <col width="18%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.mission.mission.index.start_date').'|column:starts_at')
    <th></th>
    @th(__('addworking.mission.mission.index.status').'|not_allowed')
    @th(__('addworking.mission.mission.index.label').'|not_allowed')
    @th(__('addworking.mission.mission.index.service_provider').'|not_allowed')
    @th(__('addworking.mission.mission.index.customer').'|not_allowed')
    @th(__('addworking.mission.mission.index.finish').'|not_allowed')
    @th(__('addworking.mission.mission.index.number').'|not_allowed|class:text-center')
    @th(__('addworking.mission.mission.index.amount').'|not_allowed|class:text-right')
    @th (__('addworking.mission.mission.index.actions').'|not_allowed|class:text-right')
@endsection

@section('table.filter')
    <td>
    @form_control([
        'type'  => "date",
        'name'  => "filter[starts_at]",
        'value' => request()->input('filter.starts_at')
    ])
    </td>
    <td></td>
    <td>
        <select class="form-control" name="filter[status]">
            <option></option>
            @foreach(mission()::getAvailableStatuses() as $status)
                <option value="{{ $status }}" @if(request()->input('filter.status') == $status) selected @endif>@lang("mission.mission.status_{$status}")</option>
            @endforeach
        </select>
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[label]",
        'value' => request()->input('filter.label')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[vendor]",
        'value' => request()->input('filter.vendor')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[customer]",
        'value' => request()->input('filter.customer')
        ])
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        @button(['icon' => "check", 'type' => "sumbit"])
    </td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $mission)
        <tr>
            <td>@date($mission->starts_at)</td>
            <td>
                @if($mission->created_at->diffInHours(now())< 3)
                    <span class="badge badge-pill badge-info">{{ __('addworking.mission.mission.index.new') }}</span>
                @endif
            </td>
            <td>@include('addworking.mission.mission._status')</td>
            <td>
                <span @tooltip($mission->label)>
                    <a href="{{ route('mission.show', $mission) }}">{{ short_string((string)$mission->label, 30) }} </a>
                </span>
            </td>
            <td>{{ $mission->vendor->views->link }}</td>
            <td>{{ $mission->customer->views->link }}</td>
            <td>
                @if($mission->closed_at)
                    <span class="text-danger" @tooltip(__('addworking.mission.mission.index.mission_closed_by')." {$mission->closed_by} le {$mission->closed_at}")> {{ __('addworking.mission.mission.index.finish') }}</span>
                @else
                    <span class="text-success"> {{ __('addworking.mission.mission.index.no') }}</span>
                @endif
            </td>
            <td class="text-center">{{ $mission->number }}</td>
            <td class="text-right">@money($mission->amount)</td>
            <td class="text-right">{{ $mission->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection

