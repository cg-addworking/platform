<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\Proposal\StoreRequest;
use App\Http\Requests\Addworking\Mission\Proposal\UpdateRequest;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Notifications\Mission\Proposal\Accept;
use App\Notifications\Mission\Proposal\Assign;
use App\Notifications\Mission\Proposal\Decline;
use App\Repositories\Addworking\Mission\ProposalRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProposalController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ProposalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Proposal::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request) {
            $enterprise = $request->user()->enterprise;
            $passwork   = $request->user()->sogetrelPasswork;

            $query
                ->when(
                    $enterprise->isHybrid() && !$request->user()->isSupport(),
                    function ($q) use ($enterprise) {
                        $q->where('vendor_enterprise_id', $enterprise->id);
                    }
                )
                ->when(
                    $enterprise->isVendor() && ! $enterprise->isHybrid() && !$request->user()->isSupport(),
                    function ($q) use ($enterprise, $passwork) {
                        $q->ofVendor($enterprise, $passwork)->exceptDraft();
                    }
                )
                ->when($enterprise->isCustomer() && ! $enterprise->isHybrid()
                    && !$request->user()->isSupport(), function ($q) use ($enterprise) {
                        $q->whereHas('offer', function ($query) use ($enterprise) {
                            $query->ofCustomer($enterprise);
                        });
                    });
        });

        return view($this->views['index'] ?? 'addworking.mission.proposal.index', @compact('items'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('store', Proposal::class);

        $proposals = $this->repository->createFromRequest($request);
        session()->flash('nav-proposals', true);

        return redirect_when(
            count($proposals),
            route($this->redirects['store']
                ?? 'mission.offer.show', Offer::find($request->input('mission_offer.id')))
        );
    }

    public function show(Proposal $proposal)
    {
        $this->authorize('show', $proposal);

        return view($this->views['show'] ?? 'addworking.mission.proposal.show', @compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $this->authorize('edit', $proposal);

        return view($this->views['edit'] ?? 'addworking.mission.proposal.edit', @compact('proposal'));
    }

    public function update(UpdateRequest $request, Proposal $proposal)
    {
        $this->authorize('store', $proposal);

        $saved = transaction(function () use ($request, $proposal) {
            $proposal->fill($request->input('mission_proposal'));

            return $proposal->save();
        });

        if (! $proposal->isDraft()) {
            Offer::find($proposal->missionOffer->id)->update([
                'status' => Offer::STATUS_COMMUNICATED,
            ]);
        }

        return $saved
            ? redirect()->route($this->redirects['update'] ?? 'mission.proposal.show', $proposal)
                ->with(success_status('Proposition de mission modifiée avec succès'))
            : back()->with(error_status());
    }

    public function destroy(Proposal $proposal)
    {
        $this->authorize('destroy', $proposal);

        $deleted = $proposal->delete();

        return $deleted
            ? redirect()->route($this->redirects['destroy'] ?? 'mission.offer.index')
                ->with(success_status("Proposition de mission supprimée avec succès"))
            : back()->with(error_status());
    }

    /**
     * @todo v0.41.1 use ProposalRepository@setStatus
     */
    public function assign(Proposal $proposal)
    {
        $this->authorize('assign', $proposal);

        $saved = transaction(function () use ($proposal) {
            $proposal->status = Proposal::STATUS_ASSIGNED;
            $proposal->save();

            return Mission::createFromProposal($proposal);
        });

        //Send mail notification to vendor
        if ($saved) {
            Notification::send($proposal->vendor->users, new Assign($proposal));
        }

        return $saved
            ? back()->with(success_status('Proposition de mission assignée'))
            : back()->with(error_status());
    }

    public function updateProposalStatus(Proposal $proposal, Request $request)
    {
        $this->authorize('interestedStatus', $proposal);

        $proposal = $this->repository->setStatus($proposal, $request);

        return redirect_when($this->redirects['update_status'] ?? $proposal->exists, $proposal->routes->show);
    }
}
