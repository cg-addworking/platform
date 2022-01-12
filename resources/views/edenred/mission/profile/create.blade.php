@extends('addworking.mission.profile.create', [
    'index' => 'edenred.mission-offer.index',
    'show'  => 'edenred.mission-offer.show'
])

@section('table')
    <table class="table table-hover" id="enterprise-list">
        <thead>
            <th>{{ __('edenred.mission.profile.create.enterprise') }}</th>
            <th class="text-center">{{ __('edenred.mission.profile.create.esn_on_mission_code') }}</th>
            <th class="text-center">
                <input type="checkbox" id="select-all">
            </th>
        </thead>
        <tbody>
            @forelse ($items as $enterprise)
                <tr>
                    <td>{{ $enterprise->name }}</td>
                    <td class="text-center">
                        @if ($enterprise->hasRateForOffer($offer))
                            @icon('check|color:success')
                        @else
                            @icon('times|color:danger')
                        @endif
                    </td>
                    <td class="text-center">
                        @if($offer->proposals()->where('vendor_enterprise_id', $enterprise->id)->count() == 0)
                            <input type="checkbox" name="vendor[id][]" value="{{ $enterprise->id }}">
                        @else
                            <b>{{ __('edenred.mission.profile.create.already_sent') }}</b>
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
