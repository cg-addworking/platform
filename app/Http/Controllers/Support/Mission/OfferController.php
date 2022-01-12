<?php

namespace App\Http\Controllers\Support\Mission;

use App\Http\Controllers\Addworking\Mission\OfferController as Controller;
use App\Models\Addworking\Mission\Offer;
use App\Repositories\Addworking\Common\JobRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\Edenred\Mission\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct(
        OfferRepository $repository,
        MissionRepository $missionRepository,
        UserRepository $userRepository,
        JobRepository $jobRepository
    ) {
        parent::__construct($repository, $missionRepository, $userRepository, $jobRepository);
    }

    public function index(Request $request)
    {
        $this->authorize('index', Offer::class);

        $items = $this->getPaginatorFromRequest($request, null, $this->repository);

        return view($this->views['index'] ?? 'addworking.mission.offer.index', @compact('items'));
    }
}
