<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

<a href="{{ route('mission.proposal.show', $proposal) }}" class="dropdown-item">
    <i class="mr-3 fa-fw fa fa-eye"></i> {{ __('addworking.mission.proposal._actions.consult') }}
</a>

@can('indexOfferAnswers', [proposal_response(), $proposal->offer])
    @if (subdomain('edenred'))
        <a href="{{ route('edenred.enterprise.offer.response.index', [$proposal->offer->customer, $proposal->offer]) }}" class="dropdown-item">
            @icon('eye|color:muted|mr:3') {{ __('addworking.mission.proposal._actions.responses') }}
        </a>
    @else
        <a href="{{ route('enterprise.offer.response.index', [$proposal->offer->customer, $proposal->offer]) }}" class="dropdown-item">
            @icon('eye|color:muted|mr:3') {{ __('addworking.mission.proposal._actions.responses') }}
        </a>
    @endif
@endcan

@can('assign', [mission_proposal(), $proposal])
    <a class="dropdown-item" title="Assigner la mission" data-toggle="modal" data-target="#assign-proposal-{{ $proposal->id }}">
        <i class="mr-3 fa-fw fa fa-thumbs-up"></i> {{ __('addworking.mission.proposal._actions.assing_mission') }}
    </a>
@endcan

@can('edit', [mission_proposal(), $proposal])
    <a href="{{ route('mission.proposal.edit', $proposal) }}" class="dropdown-item text-warning">
        <i class="mr-3 fa-fw fa fa-edit text-warning"></i> {{ __('addworking.mission.proposal._actions.edit') }}
    </a>
@endcan

@can('destroy', [mission_proposal(), $proposal])
<div class="dropdown-divider"></div>
    <a class="dropdown-item text-danger" title="Supprimer" data-toggle="modal" data-target="#destroy-mission-proposal-{{ $proposal->id }}">
        <i class="mr-3 fa-fw fa fa-trash text-danger"></i> {{ __('addworking.mission.proposal._actions.remove') }}
    </a>
@endcan

@push('modals')
    @can('assign', [mission_proposal(), $proposal])
        @component('components.modal.post_confirm', [
                'id' => "assign-proposal-{$proposal->id}",
                'action' => route('mission.proposal.assign', [$proposal])
                ])
            @slot('title')
                {{ __('addworking.mission.proposal._actions.confirmation') }}
            @endslot

            {{ __('addworking.mission.proposal._actions.assign_proposal_confirm') }}
        @endcomponent
    @endcan

    @can('destroy', [mission_proposal(), $proposal])
        @component('components.modal.post_confirm', [
                'id' => "destroy-mission-proposal-{$proposal->id}",
                'action' => route('mission.proposal.destroy', $proposal)
                ])
            @slot('title')
                {{ __('addworking.mission.proposal._actions.confirmation') }}
            @endslot

            {{ __('addworking.mission.proposal._actions.delete_proposal_confirm') }}
        @endcomponent
    @endcan
@endpush

    </div>
</div>
