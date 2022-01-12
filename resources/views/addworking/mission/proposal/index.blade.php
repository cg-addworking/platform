@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.proposal.index.mission_proposal'))

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.proposal.index.mission_proposal')."|active")
@endsection

@section('table.head')
    @th(__('addworking.mission.proposal.index.mission_offer').'|column:label')
    @th(__('addworking.mission.offer.index.customer').'|not_allowed')
    @th(__('addworking.mission.proposal.index.referent')."|not_allowed")
    @th(__('addworking.mission.proposal.index.service_provider').'|not_allowed')
    @th(__('addworking.mission.proposal.index.desired_start_date').'|not_allowed')
    @th(__('addworking.mission.proposal.index.status').'|not_allowed')
    @th(__('addworking.mission.offer.index.actions').'|not_allowed|class:text-right')
@endsection

@section('table.filter')
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
        @form_control([
        'type'  => "text",
        'name'  => "filter[vendor]",
        'value' => request()->input('filter.vendor')
        ])
    </td>
    <td>
        @form_control([
            'type'  => "date",
            'name'  => "filter[starts_at_desired]",
            'value' => request()->input('filter.starts_at_desired'),
        ])
    </td>
    <td>
        <select class="form-control" name="filter[status]">
            <option></option>
            @foreach(mission_proposal()::getAvailableStatuses() as $status)
                <option value="{{ $status }}" @if(request()->input('filter.status') == $status) selected @endif>@lang("mission.proposal.status.{$status}")</option>
            @endforeach
        </select>
    </td>
    <td class="text-right">
        @button(['icon' => "check", 'type' => "sumbit"])
    </td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $proposal)
        <tr>
            <td>{{ $proposal->missionOffer->label }}</td>
            <td>{{ $proposal->missionOffer->customer->name }}</td>
            <td>{{ $proposal->offer->referent->views->link }}</td>
            <td>{{ $proposal->vendor->views->link }}</td>
            <td>@date($proposal->offer->starts_at_desired)</td>
            <td>{{ __("mission.proposal.status.{$proposal->status}") }}</td>
            <td class="text-right">{{ $proposal->views->actions }}</td>
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

