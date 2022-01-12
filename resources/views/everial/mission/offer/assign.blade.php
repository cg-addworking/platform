@extends('addworking.mission.offer.assign', [
    'back' => 'everial.mission-offer.index',
])

@section('table')
    <table class="table table-hover" id="enterprise-list">
        <thead>
            @th(__('everial.mission.offer.assign.service_provider')."|not_allowed")
            @th(__('everial.mission.offer.assign.negotiated_rate')."|not_allowed|class:text-center")
            @th(__('everial.mission.offer.assign.better_said')."|not_allowed|class:text-center")
            @th(__('everial.mission.offer.assign.action')."|not_allowed|class:text-right")
        </thead>
        <tbody>
        @forelse ($offer->customer->family()->vendors() as $vendor)
            <tr>
                <td>{{ $vendor->name }}</td>
                <td class="text-center">
                    {{ price()::getPriceFromReferential($offer->everialReferentialMissions()->firstOrNew([]), $enterprise) }}
                </td>
                <td class="text-center">
                    @if(referential()::getBestBidderFromOffer($offer, $enterprise))
                        <i class='fas fa-check text-success'></i>
                    @else
                        <i class="fas fa-times text-danger"></i>
                    @endif
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="modal" data-target="#assign-modal-{{$vendor->id}}">
                        <i class="fas fa-fw fa-check"></i> {{__('addworking.mission.offer.assign.assign')}}
                    </button>
                    @push('modals')
                        @include('addworking.mission.offer.assign_modal')
                    @endpush
                </td>
            </tr>
        @empty
            <tr>
                <td>@lang('messages.empty')</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
