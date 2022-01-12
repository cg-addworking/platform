<?php

namespace Components\Mission\Offer\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Presenters\OfferListPresenter;
use Components\Mission\Offer\Application\Presenters\OfferShowPresenter;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Application\Repositories\SkillRepository;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Mission\Offer\Application\Requests\StoreConstructionOfferRequest;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\UseCases\CloseOffer;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionOffer;
use Components\Mission\Offer\Domain\UseCases\DeleteOffer;
use Components\Mission\Offer\Domain\UseCases\EditConstructionOffer;
use Components\Mission\Offer\Domain\UseCases\ListOffer;
use Components\Mission\Offer\Domain\UseCases\SendOfferToEnterprise;
use Components\Mission\Offer\Domain\UseCases\ShowConstructionOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Addworking\Common\File;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', Offer::class);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $searchable_attributes = App::make(OfferRepository::class)->getSearchableAttributes();
        $statuses = App::make(OfferRepository::class)->getAvailableStatuses(true);

        $presenter = new OfferListPresenter;
        $items = App::make(ListOffer::class)->handle(
            $presenter,
            $authenticated,
            $request->input('filter'),
            $request->input('search'),
            $request->input('per-page'),
            $request->input('operator'),
            $request->input('field'),
        );

        return view(
            'offer::offer.index',
            compact('items', 'statuses', 'searchable_attributes')
        );
    }

    public function create(Request $request)
    {
        $this->authorize('create', Offer::class);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');
        $offer = App::make(OfferRepository::class)->make();
        $enterprises = App::make(UserRepository::class)->isSupport($authenticated)
            ? App::make(EnterpriseRepository::class)->getAllEnterprises()->pluck('name', 'id')
            : App::make(EnterpriseRepository::class)->getEnterprisesOf($authenticated)->pluck('name', 'id');

        $workfield = $owner = $selected_departments = null;

        if ($request->input('workfield_id')) {
            $workfield = App::make(WorkFieldRepository::class)->find($request->input('workfield_id'));
            $owner = $workfield->getOwner()->id;
            $selected_departments = $workfield->getDepartments()->pluck('name', 'id')->toArray();
            $workfield = $workfield->getId();
        }

        return view(
            'offer::offer.create',
            compact(
                'authenticated',
                'enterprises',
                'departments',
                'workfield',
                'owner',
                'offer',
                'selected_departments'
            )
        );
    }

    public function store(StoreConstructionOfferRequest $request)
    {
        $this->authorize('create', Offer::class);

        $inputs = $request->input('offer');

        if (! $request->has('offer.enterprise_id')) {
            /** @var WorkField $work_field */
            $work_field = App::make(WorkFieldRepository::class)->find($request->input('offer.workfield_id'));
            $inputs['enterprise_id'] = $work_field->getOwner()->getId();
        }

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $offer = App::make(CreateConstructionOffer::class)->handle(
            $authenticated,
            $inputs,
            $request->file('offer.file')
        );

        return $offer->getStatus() != OfferEntityInterface::STATUS_DRAFT ?
            $this->redirectWhen($offer->exists, route('sector.offer.send_to_enterprise', $offer))
            : $this->redirectWhen($offer->exists, route('sector.offer.show', $offer));
    }

    public function show(Offer $offer)
    {
        $this->authorize('show', $offer);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $departments = $offer->getDepartments()->pluck('display_name')->sort()->toArray();
        $recipients = App::make(ProposalRepository::class)->getOfferProposals($offer);

        $presenter = new OfferShowPresenter;
        $offer = App::make(ShowConstructionOffer::class)->handle($presenter, $authenticated, $offer);

        return view('offer::offer.show', compact('offer', 'departments', 'recipients'));
    }

    public function edit(Offer $offer)
    {
        $this->authorize('edit', $offer);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $departments = Department::orderBy('insee_code', 'asc')->cursor()->pluck('name', 'id');
        $enterprises = $offer->getCustomer()->pluck('name', 'id');
        $selected_departments = $offer->getDepartments()->pluck('id')->toArray();
        $selected_skills = json_encode($offer->getSkills()->pluck('id')->toArray());

        $workfield = null;
        $owner = null;

        if ($offer->getWorkfield()) {
            $workfield = $offer->getWorkField();
            $owner = $workfield->getOwner()->id;
            $workfield = $workfield->getId();
        }

        return view('offer::offer.edit', compact(
            'authenticated',
            'enterprises',
            'departments',
            'workfield',
            'owner',
            'offer',
            'selected_departments',
            'selected_skills'
        ));
    }

    public function update(Offer $offer, Request $request)
    {
        // TODO: add validation request
        $this->authorize('edit', $offer);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $offer = App::make(EditConstructionOffer::class)
            ->handle($authenticated, $offer, $request->input('offer'), $request->file('offer.file'));

        return $this->redirectWhen($offer->exists, route('sector.offer.show', $offer));
    }

    public function sendToEnterprise(Offer $offer, Request $request)
    {
        $this->authorize('sendToEnterprise', $offer);

        $enterprise = $offer->getCustomer();
        $vendors = App::make(SkillRepository::class)
            ->getVendorsWithSkills($enterprise, $request->input('filter.skills') ?? []);

        $skills = App::make(SkillRepository::class)->getOfferSkillsList($offer);

        $response_deadline_is_passed = false;

        if (! is_null($offer->getResponseDeadline())) {
            $response_deadline_is_passed = $offer->getResponseDeadline()->lt(Carbon::now());
        }

        return view(
            'offer::offer.send_to_enterprise',
            compact('vendors', 'offer', 'skills', 'response_deadline_is_passed')
        );
    }

    public function sendToEnterpriseStore(Offer $offer, Request $request)
    {
        $this->authorize('sendToEnterprise', $offer);

        $request->validate([
            'offer.vendor.*' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if (! is_null($offer->getResponseDeadline()) && $offer->getResponseDeadline()->lt(Carbon::now())) {
            return back()->with('status', [
                'class' => 'danger',
                'message' => __('offer::offer.send_to_enterprise.edit_response_deadline')
            ]);
        }

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $saved = App::make(SendOfferToEnterprise::class)->handle($authenticated, $offer, $request->input('offer'));

        return $this->redirectWhen($saved->exists, route('sector.offer.show', $offer));
    }

    public function close(Offer $offer)
    {
        $this->authorize('close', $offer);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $closed = App::make(CloseOffer::class)->handle($authenticated, $offer);

        return $this->redirectWhen($closed->exists, route('mission.index'));
    }

    public function delete(Offer $offer)
    {
        $this->authorize('delete', $offer);

        $deleted = App::make(DeleteOffer::class)
            ->handle(App::make(UserRepository::class)->connectedUser(), $offer);

        return $this->redirectWhen($deleted, route('sector.offer.index'));
    }

    public function deleteFile(Offer $offer, File $file)
    {
        $deleted = App::make(OfferRepository::class)->deleteFile($file);

        return $this->redirectWhen($deleted, route('sector.offer.show', $offer));
    }

      /////////////////////////////////////////////////////
     // Ajax requests                                   //
    /////////////////////////////////////////////////////
    public function getWorkfieldsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $workfields = WorkField::whereHas('owner', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            })->latest()->pluck('display_name', 'id');

            $response = [
                'status' => 200,
                'data' => $workfields,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getReferentsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $referents = $enterprise->users()->orderBy('lastname', 'asc')->get()->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $referents,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getSkillsOf(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $skills = App::make(SkillRepository::class)->getSkillsList($enterprise);

            $response = [
                'status' => 200,
                'data' => $skills,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function setResponseDeadline(Request $request)
    {
        $table = (new Offer)->getTable();

        $request->validate([
            'offer'    => "required|uuid|exists:$table,id",
            'response_deadline' => "required|date"
        ]);

        if ($request->ajax()) {
            $offer = Offer::where('id', $request->input('offer'))->first();
            $offer->setResponseDeadline($request->input('response_deadline'));
            App::make(OfferRepository::class)->save($offer);

            $response = [
                'status' => 200,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
