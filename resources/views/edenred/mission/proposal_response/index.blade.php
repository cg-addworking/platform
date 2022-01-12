@extends('addworking.mission.proposal_response.index', [
    'index_offer'     => 'edenred.mission-offer.index',
    'show_offer'      => 'edenred.mission-offer.show',
    'response_create' => 'edenred.enterprise.offer.proposal.response.create',
])

@section('table.colgroup')
    <col width="25%">
    <col width="15%">
    <col width="15%">
    <col width="15%">
    <col width="25%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('edenred.mission.proposal_response.index.service_provider').'|not_allowed')
    @th(__('edenred.mission.proposal_response.index.reference_tjm').'|not_allowed')
    @th(__('edenred.mission.proposal_response.index.tjm_proposed').'|not_allowed')
    @th(__('edenred.mission.proposal_response.index.status').'|not_allowed')
    @th(__('edenred.mission.proposal_response.index.created_at').'|column:created_at')
    @th(__('edenred.mission.proposal_response.index.actions').'|not_allowed')
@endsection

@section('table.body')
    @forelse ($items as $response)
        <tr>
            <td>{{ $response->proposal->vendor->views->link }}</td>
            <td>@money(edenred_average_daily_rate('')->ofCode($offer->edenredCodes()->first())->get()->where('vendor_id', $response->proposal->vendor->id)->first()->rate ?? '0.0')</td>
            <td>@money($response->unit_price) @if($response->unit)/ @lang('mission.response.unit.'.$response->unit) @endif</td>
            <td>@lang('mission.response.status.'.$response->status)</td>
            <td>@date($response->created_at)</td>
            <td class="text-center">
                <a href="{{ route('edenred.enterprise.offer.proposal.response.show', [$offer->customer, $offer, $proposal ?? $response->proposal, $response]) }}" class="btn btn-small">
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
