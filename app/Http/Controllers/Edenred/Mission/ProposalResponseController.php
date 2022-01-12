<?php

namespace App\Http\Controllers\Edenred\Mission;

use App\Http\Controllers\Addworking\Mission\ProposalResponseController as Controller;
use App\Http\Requests\Addworking\Mission\Response\StoreProposalResponseRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\Mission\ProposalResponseRepository;
use App\Repositories\Edenred\Mission\OfferRepository;
use App\Repositories\Edenred\Mission\ProposalResponseRepository as EdenredResponseRepository;

class ProposalResponseController extends Controller
{
    protected $views = [
        'index'  => 'edenred.mission.proposal_response.index',
        'show'   => 'edenred.mission.proposal_response.show',
        'create' => 'edenred.mission.proposal_response.create',
    ];

    protected $redirects = [
        'store'         => "edenred.enterprise.offer.proposal.response.show",
        'update'        => "edenred.enterprise.offer.proposal.response.show",
        'update_status' => "edenred.enterprise.offer.proposal.response.show",
    ];

    protected $edenredResponseRepository;

    public function __construct(
        EdenredResponseRepository $edenredResponseRepository,
        ProposalResponseRepository $responseRepository,
        MissionRepository $missionRepository,
        OfferRepository $offerRepository
    ) {
        $this->edenredResponseRepository = $edenredResponseRepository;

        parent::__construct($responseRepository, $missionRepository, $offerRepository);
    }

    public function store(
        Enterprise $enterprise,
        Offer $offer,
        Proposal $proposal,
        StoreProposalResponseRequest $request
    ) {
        $this->authorize('store', [ProposalResponse::class, $proposal]);

        $response = $this->edenredResponseRepository->createFromRequest($proposal, $request);

        return redirect_when($this->redirects['store'] ?? $response->exists, route(
            'edenred.enterprise.offer.proposal.response.show',
            ['enterprise' => $proposal->offer->customer,
                'offer'      => $proposal->mission_offer_id,
                'proposal'   => $proposal,
                'response'   => $response]
        ));
    }
}
