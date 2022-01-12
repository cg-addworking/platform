@switch(config('app.subdomain'))
    @case('sogetrel')
    <div class="dropdown">
        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
            <a href="{{ route('mission.proposal.show', $proposal) }}" class="dropdown-item">
                <i class="mr-3 fa-fw fa fa-gift"></i> {{ __('addworking.mission.offer._proposal_actions.consult_proposal') }}
            </a>

            @foreach($proposal->vendor->sogetrelPassworks() as $passwork)
                <a href="{{ route('sogetrel.passwork.show', $passwork) }}" class="dropdown-item" >
                    <i class="mr-3 fa-fw fa fa-id-card"></i> {{ __('addworking.mission.offer._proposal_actions.consult_passwork') }}
                </a>
            @endforeach

            <a href="{{ route($response_index ?? 'enterprise.offer.proposal.response.index', [$offer->customer, $offer, $proposal]) }}" class="dropdown-item" >
                <i class="mr-3 fa-fw fa fa-eye"></i> {{ __('addworking.mission.offer._proposal_actions.view_responses') }}
            </a>
        </div>
    </div>
    @break

    @default
    <a href="{{ route($response_index ?? 'enterprise.offer.proposal.response.index', [$offer->customer, $offer, $proposal]) }}" class="btn btn-small">
        <i class="text-muted fa fa-eye"></i>
    </a>
    @break
@endswitch
