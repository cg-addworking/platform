@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.proposal_response.index.offer_answer')." ". $offer->label)

@section('toolbar')
    @if(isset($proposal))
        @can('create', [proposal_response(), $proposal])
            @button(__('addworking.mission.proposal_response.index.new_response')."|href:".route($response_create ?? 'enterprise.offer.proposal.response.create', [$offer->customer, $offer, $proposal])."|icon:plus|color:outline-success|outline|sm")
        @endcan
    @endif
    @if(auth()->user()->enterprise->is_customer)
        @cannot('close', $offer)
            <a class="text-center btn btn-outline-primary ml-2" href="{{ route('enterprise.offer.request', [$offer->customer, $offer]) }}">
                @icon('envelope|color:primary|mr:2') {{ __('addworking.mission.proposal_response.index.closing_request') }}
            </a>
        @endcannot
        @can('close', $offer)
            <a class="text-center btn btn-outline-primary ml-2" href="#" onclick="confirm('Vous avez {{ $numberOfResponses ?? '0' }} {{ __('addworking.mission.proposal_response.index.close_assignment_confirm') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('check|color:primary|mr:3') {{ __('addworking.mission.proposal_response.index.close_offer') }}
            </a>

            @push('modals')
                <form name="{{ $name }}" action="{{ route('mission.offer.close', $offer) }}" method="POST">
                    @csrf
                </form>
            @endpush
        @endcan
    @endif
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal_response.index.dashboard')."|href:".route('dashboard'))
    @if(auth()->user()->enterprise->is_vendor)
        @breadcrumb_item(__('addworking.mission.proposal_response.index.mission_proposal').'|href:'.route('mission.proposal.index') )
        @if(isset($proposal))
            @breadcrumb_item($proposal->label .'|href:'.route('mission.proposal.show', [$offer->customer, $proposal]) )
        @endif
    @else
        @breadcrumb_item(__('addworking.mission.proposal_response.index.mission_offer').'|href:'.route('mission.offer.index') )
        @breadcrumb_item($offer->label .'|href:'.route('mission.offer.show', $offer) )
    @endif
    @breadcrumb_item(__('addworking.mission.proposal_response.index.response')."|active")
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="20%">
    <col width="20%">
    <col width="20%">
    <col width="15%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.mission.proposal_response.index.mission_offer').'|not_allowed')
    @th(__('addworking.mission.proposal_response.index.client_company').'|not_allowed')
    @th(__('addworking.mission.proposal_response.index.provider_company').'|not_allowed')
    @th(__('addworking.mission.proposal_response.index.status').'|not_allowed')
    @th(__('addworking.mission.proposal_response.index.created').'|column:created_at')
    @th(__('addworking.mission.proposal_response.index.action').'|not_allowed')
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
        'name'  => "filter[vendor]",
        'value' => request()->input('filter.vendor')
        ])
    </td>
    <td>
        <select class="form-control" name="filter[status]">
            <option></option>
            @foreach(proposal_response()::getAvailableStatuses() as $status)
                <option value="{{ $status }}" @if(request()->input('filter.status') == $status) selected @endif>@lang("mission.response.status.{$status}")</option>
            @endforeach
        </select>
    </td>
    <td>
        @form_control([
            'type'  => "date",
            'name'  => "filter[created_at]",
            'value' => request()->input('filter.created_at'),
        ])
    </td>
    <td class="text-right">
        @button(['icon' => "check", 'type' => "sumbit"])
    </td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $response)
        <tr>
            <td>{{ $offer->label }}</td>
            <td>{{ $offer->customer->views->link }}</td>
            <td>{{ $response->proposal->vendor->views->link }}</td>
            <td>@lang('mission.response.status.'.$response->status)</td>
            <td>@date($response->created_at)</td>
            <td class="text-center">
                <a href="{{ route('enterprise.offer.proposal.response.show', [$offer->customer, $offer, $proposal ?? $response->proposal, $response]) }}" class="btn btn-small">
                    <i class="text-muted fa fa-eye"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
