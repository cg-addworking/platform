<?php

namespace App\Http\Controllers\Addworking\Mission;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\MissionTracking\StoreMissionTrackingRequest;
use App\Http\Requests\Addworking\Mission\MissionTracking\UpdateMissionTrackingRequest;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use App\Repositories\Addworking\Mission\MissionTrackingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionTrackingController extends Controller
{
    use HandlesIndex;

    protected $repository;
    protected $missionTrackingLineRepository;

    public function __construct(
        MissionTrackingRepository $repository,
        MissionTrackingLineRepository $mission_tracking_line_repository
    ) {
        $this->repository = $repository;
        $this->missionTrackingLineRepository = $mission_tracking_line_repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', MissionTracking::class);
            $enterprise = $request->user()->enterprise;

        switch (true) {
            case $enterprise->isHybrid() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofEnterprise($enterprise);
                });
                break;
            case $enterprise->isVendor() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofVendor($enterprise);
                });
                break;
            case $enterprise->isCustomer() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofCustomer($enterprise);
                });
                break;
            default:
                $items = $this->getPaginatorFromRequest($request);
                break;
        }

        return view('addworking.mission.mission_tracking.index', @compact('items'));
    }

    public function create(Mission $mission)
    {
        $this->authorize('create', MissionTracking::class);

        $tracking = $this->repository->factory()->mission()->associate($mission);

        return view('addworking.mission.mission_tracking.create', @compact('mission', 'tracking'));
    }

    public function store(Mission $mission, StoreMissionTrackingRequest $request)
    {
        $this->authorize('store', MissionTracking::class);

        $request->validate([
            'line.label'            => 'nullable|string',
            'line.quantity'         => 'required|numeric',
            'line.unit'             => 'required|string',
            'line.unit_price'       => 'required|numeric',
        ]);

        $tracking = $this->repository->createFromRequest($mission, $request);
        $this->missionTrackingLineRepository->createFromRequest($tracking, $request);

        $this->repository->sendNotificationFromRequest($request, $tracking);

        return redirect_when($tracking->exists, $tracking->routes->show);
    }

    public function show(Mission $mission, MissionTracking $tracking)
    {
        $this->authorize('show', $tracking);

        $trackingLines = $tracking->trackingLines->sortByDesc('created_at');

        return view('addworking.mission.mission_tracking.show', @compact('mission', 'tracking', 'trackingLines'));
    }

    public function edit(Mission $mission, MissionTracking $tracking)
    {
        $this->authorize('edit', $tracking);

        return view('addworking.mission.mission_tracking.edit', @compact('mission', 'tracking'));
    }

    public function update(UpdateMissionTrackingRequest $request, Mission $mission, MissionTracking $tracking)
    {
        $this->authorize('update', $tracking);

        $response = $this->repository->updateFromRequest($tracking, $request);

        return redirect_when($response->exists, $tracking->routes->show);
    }

    public function destroy(Mission $mission, MissionTracking $tracking)
    {
        $this->authorize('destroy', $tracking);

        $deleted = $tracking->delete();

        return redirect_when($deleted, $tracking->routes->index);
    }
}
