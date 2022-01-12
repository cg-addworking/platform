<?php

namespace Components\Sogetrel\Mission\Application\Controllers;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Support\Facades\Repository;
use Components\Mission\Mission\Domain\UseCases\CreateTracking;
use Components\Mission\Mission\Domain\UseCases\CreateTrackingLine;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Application\Repositories\MissionTrackingLineAttachmentRepository;
use Components\Sogetrel\Mission\Application\Requests\StoreMissionTrackingLineAttachmentRequest;
use Components\Sogetrel\Mission\Application\Requests\UpdateMissionTrackingLineAttachmentRequest;
use Components\Sogetrel\Mission\Domain\UseCases\AttachFileToMissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Domain\UseCases\CreateMissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Domain\UseCases\UpdateMissionTrackingLineAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MissionTrackingLineAttachmentController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(
        MissionTrackingLineAttachmentRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', MissionTrackingLineAttachment::class);

        /**
         * @todo this montruosity needs some refactoring
         */
        $mission_tracking_line_attachment = $this->repository->make();

        $items = $this->repository->list($request);

        $searchable_attributes = $this->repository->getSearchableAttributes();

        return view(
            'sogetrel_mission::mission_tracking_line_attachment.index',
            compact('mission_tracking_line_attachment', 'items', 'searchable_attributes')
        );
    }

    public function create()
    {
        $this->authorize('create', MissionTrackingLineAttachment::class);

        $mission_tracking_line_attachment = $this->repository->make();

        return view(
            'sogetrel_mission::mission_tracking_line_attachment.create',
            compact('mission_tracking_line_attachment')
        );
    }

    public function store(
        StoreMissionTrackingLineAttachmentRequest $request
    ) {
        $this->authorize('create', MissionTrackingLineAttachment::class);

        $mission_tracking_line_attachment = DB::transaction(function () use ($request) {
            $customer   = $request->getCustomer();
            $vendor     = $request->getVendor($customer);
            $mission    = $request->getMission($vendor);
            $milestone  = $request->getMilestone($mission);

            $data       = $request->input('mission_tracking_line_attachment', []);
            $tracking   = App::make(CreateTracking::class)->handle($mission, $milestone);
            $line       = App::make(CreateTrackingLine::class)->handle($tracking, $data + [
                'unit_price' => $request->input('mission_tracking_line_attachment.amount'),
                'label'      => sprintf(
                    "%s - %s",
                    $request->input('mission_tracking_line_attachment.num_order'),
                    $request->input('mission_tracking_line_attachment.num_attachment')
                ),
            ]);

            $attachment = App::make(CreateMissionTrackingLineAttachment::class)->handle($line, $data);

            if ($request->hasFile('file')) {
                App::make(AttachFileToMissionTrackingLineAttachment::class)->handle(
                    $attachment,
                    $request->file('file')
                );
            }

            return $attachment;
        });

        return $this->redirectWhen(
            $mission_tracking_line_attachment->exists,
            $mission_tracking_line_attachment->routes->index
        );
    }

    public function show(
        MissionTrackingLineAttachment $mission_tracking_line_attachment
    ) {
        $this->authorize('view', $mission_tracking_line_attachment);

        return view(
            'sogetrel_mission::mission_tracking_line_attachment.show',
            compact('mission_tracking_line_attachment')
        );
    }

    public function edit(
        MissionTrackingLineAttachment $mission_tracking_line_attachment
    ) {
        $this->authorize('update', $mission_tracking_line_attachment);

        return view(
            'sogetrel_mission::mission_tracking_line_attachment.edit',
            compact('mission_tracking_line_attachment')
        );
    }

    public function update(
        UpdateMissionTrackingLineAttachmentRequest $request,
        MissionTrackingLineAttachment $mission_tracking_line_attachment
    ) {
        $this->authorize('update', $mission_tracking_line_attachment);

        $updated = App::make(UpdateMissionTrackingLineAttachment::class)->handle(
            $mission_tracking_line_attachment,
            $request->input('mission_tracking_line_attachment')
        );

        return $this->redirectWhen($updated, $mission_tracking_line_attachment->routes->show);
    }

    public function delete(
        MissionTrackingLineAttachment $mission_tracking_line_attachment
    ) {
        $this->authorize('delete', $mission_tracking_line_attachment);

        abort(501);
    }

    public function getVendors(Request $request)
    {
        $request->validate([
            'customer' => "required|uuid|exists:addworking_enterprise_enterprises,id",
        ]);

        if ($request->ajax()) {
            return $this->repository->getVendorsHavingMissionsWith(
                Repository::enterprise()->find($request->input('customer'))
            );
        }

        abort(501);
    }

    public function getMissions(Request $request)
    {
        $request->validate([
            'customer' => "required|uuid|exists:addworking_enterprise_enterprises,id",
            'vendor'   => "required|uuid|exists:addworking_enterprise_enterprises,id",
        ]);

        if ($request->ajax()) {
            return $this->repository->getMissionsBetween(
                Repository::enterprise()->find($request->input('customer')),
                Repository::enterprise()->find($request->input('vendor')),
            );
        }

        abort(501);
    }

    public function getMilestones(Request $request)
    {
        $request->validate([
            'mission'  => "required|uuid|exists:addworking_mission_missions,id",
        ]);

        if ($request->ajax()) {
            return Repository::mission()->find($request->input('mission'))->milestones;
        }

        abort(501);
    }
}
