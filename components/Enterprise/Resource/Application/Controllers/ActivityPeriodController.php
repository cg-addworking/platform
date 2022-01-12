<?php

namespace Components\Enterprise\Resource\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Repositories\ActivityPeriodRepository;
use Illuminate\Http\Request;

class ActivityPeriodController extends Controller
{
    protected $activityPeriodRepository;

    public function __construct(ActivityPeriodRepository $activityPeriodRepository)
    {
        $this->activityPeriodRepository = $activityPeriodRepository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [ActivityPeriod::class, $enterprise]);

        $activity_period = $this->activityPeriodRepository->make();
        $activity_period->customer()->associate($enterprise);

        $items = $this->activityPeriodRepository
            ->list($request->input('filter'), $request->input('search'))
            ->ofCustomer($enterprise)
            ->latest()
            ->paginate(25);

        return view('resource::activity_period.index', compact('items', 'enterprise', 'activity_period'));
    }
}
