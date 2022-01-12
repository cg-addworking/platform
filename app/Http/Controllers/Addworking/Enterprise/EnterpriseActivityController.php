<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\SaveEnterpriseSignatoryRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Repositories\Addworking\Enterprise\EnterpriseActivityRepository;
use Illuminate\Http\Request;

class EnterpriseActivityController extends Controller
{
    protected $repository;

    public function __construct(EnterpriseActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise)
    {
        $this->authorize('index', [EnterpriseActivity::class, $enterprise]);

        $activities = $enterprise->activities;

        return view('addworking.enterprise.enterprise_activity.index', @compact('enterprise', 'activities'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [EnterpriseActivity::class, $enterprise]);

        $activity = app()->environment('local')
            ? factory(EnterpriseActivity::class)->make()
            : new EnterpriseActivity;

        $activity->enterprise()->associate($enterprise);

        return view('addworking.enterprise.enterprise_activity.create', @compact('enterprise', 'activity'));
    }

    public function store(Enterprise $enterprise, Request $request)
    {
        $this->authorize('store', [EnterpriseActivity::class, $enterprise]);

        $activity = $this->repository->createFromRequest($request);

        return redirect_when($activity->exists, route('dashboard'));
    }

    public function show(Enterprise $enterprise, EnterpriseActivity $activity)
    {
        $this->authorize('show', [$activity, $enterprise]);

        return view('addworking.enterprise.enterprise_activity.show', @compact('enterprise', 'activity'));
    }

    public function edit(Enterprise $enterprise, EnterpriseActivity $activity)
    {
        $this->authorize('edit', [$activity, $enterprise]);

        return view('addworking.enterprise.enterprise_activity.edit', @compact('enterprise', 'activity'));
    }

    public function update(Enterprise $enterprise, Request $request)
    {
        $this->authorize('update', [EnterpriseActivity::class, $enterprise]);

        $activity = $request->has('activity.id')
            ? EnterpriseActivity::find($request->input('activity.id'))
            : new EnterpriseActivity;

        $activity->fill($request->input('enterprise_activity'));

        $saved = transaction(function () use ($request, $activity) {
            if (!$activity->save()) {
                return false;
            }

            foreach ($request->input('enterprise_activity.departments') as $department) {
                 $activity->departments()->attach($department);
            }

            if ($request->has('signatory')) {
                (new EnterpriseSignatoryController)->save(new SaveEnterpriseSignatoryRequest($request->input()));
            }

            return true;
        });

        return $saved
            ? redirect()->route('enterprise.show', $activity->enterprise)->with(success_status(
                __('enterprise.activity.saved')
            ))
            : redirect()->back()->with(error_status(
                __('enterprise.activity.error')
            ));
    }

    public function destroy(Enterprise $enterprise, EnterpriseActivity $activity)
    {
        $this->authorize('destroy', [$activity, $enterprise]);

        $deleted = $activity->delete();

        return $deleted
            ? redirect()->back()->with(success_status(
                __('enterprise.enterprise_activity.delete_success')
            ))
            : redirect()->back()->with(error_status(
                __('enterprise.activity.error')
            ));
    }
}
