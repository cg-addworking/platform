<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@can('edit', $proposal_response)
    <a href="{{ route('enterprise.offer.proposal.response.edit', [$proposal_response->proposal->offer->customer, $proposal_response->proposal->offer, $proposal_response->proposal, $proposal_response]) }}" class="dropdown-item text-warning">
        <i class="mr-3 fa fa-edit text-warning"></i> {{ __('addworking.mission.proposal_response._actions.edit') }}
    </a>
@endcan

    </div>
</div>
