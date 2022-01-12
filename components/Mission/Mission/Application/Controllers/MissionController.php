<?php

namespace Components\Mission\Mission\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\File;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Application\Presenters\MissionShowPresenter;
use Components\Mission\Mission\Application\Repositories\EnterpriseRepository;
use Components\Mission\Mission\Application\Repositories\NewMissionRepository as MissionRepository;
use Components\Mission\Mission\Application\Repositories\UserRepository;
use Components\Mission\Mission\Application\Repositories\WorkFieldRepository;
use Components\Mission\Mission\Application\Requests\StoreConstructionMissionRequest;
use Components\Mission\Mission\Application\Requests\UpdateConstructionMissionRequest;
use Components\Mission\Mission\Domain\UseCases\CreateConstructionMission;
use Components\Mission\Mission\Domain\UseCases\EditConstructionMission;
use Components\Mission\Mission\Domain\UseCases\ShowConstructionMission;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function create(Request $request)
    {
        $this->authorize('create', Mission::class);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $mission = App::make(MissionRepository::class)->make();
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');
        $enterprises = App::make(UserRepository::class)->isSupport($authenticated)
            ? App::make(EnterpriseRepository::class)->getAllCustomers()->pluck('name', 'id')
            : App::make(EnterpriseRepository::class)->getEnterprisesOf($authenticated)->pluck('name', 'id');

        $workfield = $owner = $selected_departments = null;

        if ($request->input('workfield_id')) {
            $workfield = App::make(WorkFieldRepository::class)->find($request->input('workfield_id'));
            $owner = $workfield->getOwner()->id;
            $selected_departments = $workfield->getDepartments()->pluck('id')->toArray();
            $workfield = $workfield->getId();
        }

        return view(
            'mission::mission.create',
            compact(
                'authenticated',
                'enterprises',
                'departments',
                'workfield',
                'owner',
                'mission',
                'selected_departments'
            )
        );
    }

    public function store(StoreConstructionMissionRequest $request)
    {
        $this->authorize('create', Mission::class);

        $inputs = $request->input('mission');

        if (! $request->has('mission.enterprise_id')) {
            /** @var WorkField $work_field */
            $work_field = App::make(WorkFieldRepository::class)
                ->find($request->input('mission.workfield_id'));
            $inputs['enterprise_id'] = $work_field->getOwner()->getId();
        }

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $mission = App::make(CreateConstructionMission::class)->handle(
            $authenticated,
            $inputs,
            $request->file('mission.file'),
            $request->file('mission.cost_estimation.file')
        );

        return $this->redirectWhen($mission->exists, route('sector.mission.show', $mission));
    }

    public function edit(Mission $mission)
    {
        $this->authorize('edit', $mission);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');
        $enterprises = [$mission->getCustomer()->id => $mission->getCustomer()->name];
        $selected_departments = $mission->getDepartments()->pluck('id')->toArray();

        $workfield = null;
        $owner = null;

        if ($mission->getWorkfield()) {
            $workfield = $mission->getWorkField();
            $owner = $workfield->getOwner()->id;
            $workfield = $workfield->getId();
        }

        return view('mission::mission.edit', compact(
            'authenticated',
            'enterprises',
            'departments',
            'workfield',
            'owner',
            'mission',
            'selected_departments',
        ));
    }

    public function update(Mission $mission, UpdateConstructionMissionRequest $request)
    {
        $this->authorize('edit', $mission);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $mission = App::make(EditConstructionMission::class)
            ->handle(
                $authenticated,
                $mission,
                $request->input('mission'),
                $request->file('mission.file'),
                $request->file('mission.cost_estimation.file')
            );

        return $this->redirectWhen($mission->exists, route('sector.mission.show', $mission));
    }

    public function show(Mission $mission)
    {
        //$this->authorize('show', $mission);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $departments = $mission->getDepartments()->pluck('display_name')->sort()->toArray();

        $presenter = new MissionShowPresenter;
        $mission = App::make(ShowConstructionMission::class)->handle($presenter, $authenticated, $mission);

        return view('mission::mission.show', compact('mission', 'departments'));
    }

    public function deleteFile(Mission $mission, File $file)
    {
        $deleted = App::make(MissionRepository::class)->deleteFile($file);

        return $this->redirectWhen($deleted, route('sector.mission.show', $mission));
    }
}
