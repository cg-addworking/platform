@extends('addworking.mission.profile.create', [
    'index'          => 'everial.mission-offer.index',
    'show'           => 'everial.mission-offer.show',
    'proposal_store' => 'everial.mission-proposal.store'
])

@section('table')
    <table class="table table-hover" id="enterprise-list">
        <thead>
            <th>{{ __('everial.mission.profile.create.enterprise') }}</th>
            <th class="text-center">{{ __('everial.mission.profile.create.negotiated_rate') }}</th>
            <th class="text-center">{{ __('everial.mission.profile.create.better_said') }}</th>
            <th class="text-center">
                <input type="checkbox" id="select-all">
            </th>
        </thead>
        <tbody>
            @forelse ($items as $enterprise)

                <tr>
                    <td>{{ $enterprise->name }}</td>
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
                    <td class="text-center">
                        @if($offer->proposals()->where('vendor_enterprise_id', $enterprise->id)->count() == 0)
                            <input type="checkbox" name="vendor[id][]" value="{{ $enterprise->id }}">
                        @else
                            <b>{{ __('everial.mission.profile.create.already_sent') }}</b>
                        @endif
                    </td>
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
        </tbody>
    </table>
@endsection