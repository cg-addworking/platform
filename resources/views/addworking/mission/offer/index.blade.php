@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.offer.index.mission_offer'))

@section('toolbar')
    @button(__('addworking.mission.offer.index.create_assignment_offer')."|href:".route($create ?? 'mission.offer.create')."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.index.mission_offer')."|active")
@endsection

@section('table.colgroup')
    <col width="15">
    <col width="30%">
    <col width="20%">
    <col width="20%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.mission.offer.index.created_on')."|column:created_at")
    @th(__('addworking.mission.offer.index.mission_offer')."|column:label")
    @th(__('addworking.mission.offer.index.customer')."|not_allowed")
    @th(__('addworking.mission.offer.index.referent')."|not_allowed")
    @th(__('addworking.mission.offer.index.status')."|not_allowed")
    @th(__('addworking.mission.offer.index.actions')."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td>
        @form_control([
            'type'  => "date",
            'name'  => "filter[created_at]",
            'class' => "form-control-sm",
            'value' => request()->input('filter.created_at'),
        ])
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
            'name'  => "filter[customer]",
            'value' => request()->input('filter.customer')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[referent]",
        'value' => request()->input('filter.referent')
        ])
    </td>
    <td>
        <select class="form-control" name="filter[status]">
            <option></option>
            @foreach(mission_offer()::getAvailableStatuses() as $status)
                <option value="{{ $status }}" @if(request()->input('filter.status') == $status) selected @endif>@lang("mission.mission.status_{$status}")</option>
            @endforeach
        </select>
    </td>
    <td>
        @button(['icon' => "check", 'type' => "sumbit"])
    </td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $offer)
        <tr>
            <td>@date($offer->created_at)</td>
            <td>{{ $offer->label }}</td>
            <td>{{ $offer->customer->name }}</td>
            <td>{{ optional(optional($offer->referent)->views)->link }}</td>
            <td>@include('addworking.mission.offer._status')</td>
            <td class="text-right">{{ $offer->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
