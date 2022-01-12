<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\MissionTrackingLine\StoreMissionTrackingLineRequest;
use App\Http\Requests\Addworking\Mission\MissionTrackingLine\UpdateMissionTrackingLineRequest;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use Illuminate\Http\Request;

class MissionTrackingLineController extends Controller
{
    protected $repository;

    public function __construct(MissionTrackingLineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(
        Mission $mission,
        MissionTracking $tracking
    ) {
        $this->authorize('viewAny', [MissionTrackingLine::class, $tracking]);

        $items = $tracking->trackingLines()->latest()->paginate(25);
        $mission_tracking_line = $this->repository->make()->missionTracking()->associate($tracking);

        return view(
            'addworking.mission.mission_tracking_line.index',
            compact('items', 'mission_tracking_line'),
        );
    }

    public function create(
        Mission $mission,
        MissionTracking $tracking
    ) {
        $this->authorize('create', [MissionTrackingLine::class, $tracking]);

        $mission_tracking_line = $this->repository->factory()->missionTracking()->associate($tracking);

        return view(
            'addworking.mission.mission_tracking_line.create',
            compact('mission_tracking_line')
        );
    }

    public function store(
        StoreMissionTrackingLineRequest $request,
        Mission $mission,
        MissionTracking $tracking
    ) {
        $this->authorize('create', [MissionTrackingLine::class, $tracking]);

        $line = $this->repository->createFromRequest($tracking, $request);

        return $this->redirectWhen($line->exists, $tracking->routes->show);
    }

    public function show(
        Mission $mission,
        MissionTracking $tracking,
        MissionTrackingLine $line
    ) {
        $this->authorize('view', $line);

        $mission_tracking_line = $line;

        return view(
            'addworking.mission.mission_tracking_line.show',
            compact('mission_tracking_line')
        );
    }

    public function edit(
        Mission $mission,
        MissionTracking $tracking,
        MissionTrackingLine $line
    ) {
        $this->authorize('edit', $line);

        return view(
            'addworking.mission.mission_tracking_line.edit',
            compact('mission', 'tracking', 'line')
        );
    }

    public function update(
        UpdateMissionTrackingLineRequest $request,
        Mission $mission,
        MissionTracking $tracking,
        MissionTrackingLine $line
    ) {
        $this->authorize('edit', $line);

        $response = $this->repository->updateFromRequest($line, $request);

        return $this->redirectWhen($response->exists, $tracking->routes->show);
    }

    public function destroy(
        Mission $mission,
        MissionTracking $tracking,
        MissionTrackingLine $line
    ) {
        $this->authorize('destroy', $line);

        $deleted = $line->delete();

        return $this->redirectWhen($deleted, $tracking->routes->show);
    }

    public function validation(
        Mission $mission,
        MissionTracking $tracking,
        MissionTrackingLine $line,
        Request $request
    ) {
        $validation = $this->repository->validation($line, $request);

        return $this->redirectWhen($validation->exists, $tracking->routes->show);
    }
}
