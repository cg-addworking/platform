<?php

namespace App\Http\Controllers\Edenred\Mission;

use App\Http\Controllers\Addworking\Mission\OfferController as Controller;
use App\Http\Requests\Addworking\Mission\Offer\StoreMissionOfferRequest;
use App\Repositories\Addworking\Common\JobRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\Edenred\Mission\OfferRepository;

class OfferController extends Controller
{
    protected $views = [
        'index'  => 'edenred.mission.offer.index',
        'create' => 'edenred.mission.offer.create',
        'show'   => 'edenred.mission.offer.show',
    ];

    protected $redirects = [
        'update'  => "edenred.mission-offer.show",
        'destroy' => "edenred.mission-offer.index"
    ];

    /**
     * Constructor
     *
     * @param OfferRepository $repository
     */
    public function __construct(
        OfferRepository $repository,
        MissionRepository $missionRepository,
        UserRepository $userRepository,
        JobRepository $jobRepository
    ) {
        parent::__construct($repository, $missionRepository, $userRepository, $jobRepository);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMissionOfferRequest $request)
    {
        // This validation is not in the request
        // because StoreMissionOfferRequest is
        // shared with another Controller which
        // doesn't handle code.id
        $request->validate([
            'code.id' => 'required|string',
        ]);

        $offer = $this->repository->createFromRequest($request);

        return redirect_when($offer->exists, route('edenred.mission-offer.show', @compact('offer')));
    }
}
