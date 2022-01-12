@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.offer.summary.responses_summary')." - ".$offer->label)

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.summary.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.summary.mission_offer').'|href:'.route($index ?? 'mission.offer.index') )
    @breadcrumb_item($offer->label .'|href:'.route($show ?? 'mission.offer.show', $offer) )
    @breadcrumb_item(__('addworking.mission.offer.summary.summary')."|active")
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="50%">
    <col width="20%">
    <col width="10%">
@endsection

@section('table.head')
    @th(__('addworking.mission.offer.summary.reply_date')."|not_allowed")
    @th(__('addworking.mission.offer.summary.enterprise')."|not_allowed")
    @th(__('addworking.mission.offer.summary.status')."|not_allowed")
    @th(__('addworking.mission.offer.summary.mission')."|not_allowed")
@endsection

@section('table.body')
    @foreach ($items as $response)
        <tr>
            <td>@date($response->created_at)</td>
            <td>{{ $response->proposal->vendor->views->link }}</td>
            <td>
                @include('addworking.mission.proposal_response._status_badge')
            </td>
            <td>
                @can('mission', $response)
                    <button type="button" class="btn btn-success btn-sm" onclick="document.forms['{{ $name = uniqid('form_') }}'].submit()">{{ __('addworking.mission.offer.summary.create') }}</button>
                    @push('modals')
                        <form name="{{ $name }}" action="{{ route('enterprise.offer.proposal.response.mission', [
                            'enterprise' => $offer->customer,
                            'offer' => $offer,
                            'proposal' => $response->proposal,
                            'response' => $response]) }}" method="POST">
                            @csrf
                        </form>
                    @endpush
                @elseif($response->mission()->exists())
                        <a href="{{$response->mission->routes->show}}">{{ __('addworking.mission.offer.summary.see_mission') }}</a>
                @else
                    <button type="button" class="btn btn-success btn-sm" disabled data-toggle="tooltip" data-placement="top" title="{{ __('addworking.mission.offer.summary.response_not_in_final_validation') }}">{{ __('addworking.mission.offer.summary.create') }}</button>
                @endcan
            </td>
        </tr>
    @endforeach

@endsection
