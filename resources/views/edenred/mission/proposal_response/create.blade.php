
@extends('addworking.mission.proposal_response.create', [
    'action' => route('edenred.enterprise.offer.proposal.response.store',[
        'enterprise' => $enterprise,
        'offer'      => $offer,
        'proposal'   => $proposal
        ])
])