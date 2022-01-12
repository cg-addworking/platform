<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@php
    switch (true) {
        case subdomain('edenred'):
            $show_offer_route     = 'edenred.mission-offer.show';
            $edit_offer_route     = 'edenred.mission-offer.edit';
            $index_response_route = 'edenred.enterprise.offer.response.index';
            break;
        case subdomain('everial'):
            $show_offer_route     = 'everial.mission-offer.show';
            $edit_offer_route     = 'everial.mission-offer.edit';
            $index_response_route = 'enterprise.offer.response.index';
            break;
        default:
            $show_offer_route     = 'mission.offer.show';
            $edit_offer_route     = 'mission.offer.edit';
            $index_response_route = 'enterprise.offer.response.index';
    }
@endphp

@can('show', $offer)
    <a class="dropdown-item" href="{{ route($show_offer_route, $offer) }}">
        @icon('eye|color:muted|mr:3') {{ __('addworking.mission.offer._actions.consult') }}
    </a>
@endcan

@can('edit', $offer)
    <a class="dropdown-item" href="{{ route($edit_offer_route, $offer) }}">
        @icon('edit|color:muted|mr:3') {{ __('addworking.mission.offer._actions.edit') }}
    </a>
@endcan

@switch(config('app.subdomain'))
    @case('sogetrel')
        @can('broadcast', $offer)
            @if(in_array($offer->status, [mission_offer()::STATUS_TO_PROVIDE, mission_offer()::STATUS_COMMUNICATED]))
                <a class="dropdown-item" href="{{route('sogetrel.mission.offer.profile.create', $offer)}}">
                    @icon('plus|color:muted|mr:3') {{ __('addworking.mission.offer._actions.choose_recp_offer') }}
                </a>
            @endif
        @endcan
        @break

    @case('everial')
        @can('broadcast', $offer)
            @if(in_array($offer->status, [mission_offer()::STATUS_TO_PROVIDE, mission_offer()::STATUS_COMMUNICATED]))
                <a class="dropdown-item" href="{{route($profile_create ?? 'enterprise.offer.profile.create', [$offer->customer, $offer])}}">
                    @icon('plus|color:muted|mr:3') {{ __('addworking.mission.offer._actions.choose_recp_offer') }}
                </a>
            @endif
        @endcan
        @break

    @default
        @can('broadcast', $offer)
            @if(in_array($offer->status, [mission_offer()::STATUS_TO_PROVIDE, mission_offer()::STATUS_COMMUNICATED]))
                <a class="dropdown-item" href="{{route($profile_create ?? 'enterprise.offer.profile.create', [$offer->customer, $offer])}}">
                    @icon('plus|color:muted|mr:3') {{ __('addworking.mission.offer._actions.choose_recp_offer') }}
                </a>
            @endif
        @endcan
        @break
@endswitch

@can('close', $offer)
    <a class="dropdown-item" href="#" onclick="confirm('Êtes-vous sûr de vouloir clore cette offre de mission ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('check|color:muted|mr:3') {{ __('addworking.mission.offer._actions.close_offer') }}
    </a>

    @push('modals')
        <form name="{{ $name }}" action="{{ route('mission.offer.close', $offer) }}" method="POST">
            @csrf
        </form>
    @endpush
@endcan

@cannot('close', $offer)
    <a class="dropdown-item" href="{{ route('enterprise.offer.request', [$offer->customer, $offer]) }}">
        @icon('envelope|color:muted|mr:3') {{ __('addworking.mission.offer._actions.closing_request') }}
    </a>
@endcannot

@can('summary', $offer)
    <a class="dropdown-item" href="{{ route('enterprise.offer.summary', [$offer->customer, $offer]) }}">
        @icon('eye|color:muted|mr:3') {{ __('addworking.mission.offer._actions.summary') }}
    </a>
@endcan

@can('indexOfferAnswers', [proposal_response(), $offer])
    <a href="{{ route($index_response_route, [$offer->customer, $offer]) }}" class="dropdown-item">
        @icon('eye|color:muted|mr:3') {{ __('addworking.mission.offer._actions.responses') }}
    </a>
@endcan

@if(count($offer->missions))
    <a class="dropdown-item" href="{{ route('mission.index') }}?filter[label]={{ $offer->label }}">
        @icon('handshake|color:muted|mr:3') {{ __('addworking.mission.offer._actions.see_missions') }}
    </a>
@endif

@can('status', $offer)
    <a class="dropdown-item" title="Changer le statut" data-toggle="modal" data-target="#change-status-{{ $offer->id }}">
        @icon('share|color:muted|mr:3') {{ __('addworking.mission.offer._actions.change_status_offer') }}
    </a>

    @push('modals')
        @component('components.form.modal', ['id' => "change-status-{$offer->id}", 'action' => route('mission.offer.update', $offer), 'title' => __('addworking.mission.offer._actions.change_status')])
            @form_group([
                'type'     => "select",
                'name'     => "mission_offer.status",
                'value'    => $offer->status,
                'options'  => array_trans(array_mirror(mission_offer()::getAvailableStatuses()),'status.'),
                'text'     => __('addworking.mission.offer._actions.status'),
                'required' => true,
            ])
        @endcomponent
    @endpush
@endcan

@can('resendProposal', $offer)
    <a class="dropdown-item" href="{{ route('mission.offer.resend-proposal', $offer) }}">
        @icon('paper-plane|color:muted|mr:3') {{ __('addworking.mission.offer._actions.relaunch_mission_proposal') }}
    </a>
@endcan

@can('destroy', $offer)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('trash|color:danger|mr:3') <span class="text-danger">{{ __('addworking.mission.offer._actions.remove') }}</span>
    </a>

    @push('modals')
        <form name="{{ $name }}" action="{{ route('mission.offer.destroy', $offer) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endcan
    </div>
</div>
