<?php

namespace App\Http\Controllers\Everial\Mission;

use App\Http\Controllers\Addworking\Mission\OfferController as Controller;
use App\Http\Requests\Addworking\Mission\Offer\StoreMissionOfferRequest;
use App\Models\Addworking\Mission\Offer;
use App\Models\Everial\Mission\Referential;
use App\Repositories\Addworking\Common\JobRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\Everial\Mission\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $views = [
        'index'  => 'everial.mission.offer.index',
        'create' => 'everial.mission.offer.create',
        'edit'   => 'everial.mission.offer.edit',
        'show'   => 'everial.mission.offer.show',
        'assign' => 'everial.mission.offer.assign',
    ];

    protected $redirects = [
        'update'  => "everial.mission-offer.show",
        'destroy' => "everial.mission-offer.index"
    ];

    public function __construct(
        OfferRepository $repository,
        MissionRepository $missionRepository,
        UserRepository $userRepository,
        JobRepository $jobRepository
    ) {
        parent::__construct($repository, $missionRepository, $userRepository, $jobRepository);
    }

    public function store(StoreMissionOfferRequest $request)
    {
        $codes = implode(',', array_keys(Referential::getAvailableAnalyticCodes()));

        // This validation is not in the request
        // because StoreMissionOfferRequest is
        // shared with another Controller which
        // doesn't handle referential.id && mission_offer.label
        $request->validate([
            'mission_offer.label'         => 'required|string|max:255',
            'mission_offer.analytic_code' => "required|in:{$codes}",
            'referential.id'              => 'required|uuid|exists:everial_mission_referential_missions,id',
        ]);

        $data = $request->input();

        $data['mission_offer']['analytic_code'] = $request->input('mission_offer.analytic_code')." 110";

        $request->merge($data);

        $offer = $this->repository->createFromRequest($request);

        return redirect_when($offer->exists, route('everial.mission-offer.show', @compact('offer')));
    }

    public function update(Request $request, Offer $offer)
    {
        $this->authorize('update', $offer);

        $offer = $this->repository->updateFromRequest($offer, $request);

        return redirect_when($offer->exists, route('everial.mission-offer.show', @compact('offer')));
    }
}
