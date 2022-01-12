<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\Response\StoreProposalResponseRequest;
use App\Http\Requests\Addworking\Mission\Response\UpdateProposalResponseRequest;
use App\Http\Requests\Addworking\Mission\Response\UpdateProposalResponseStatusRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\Mission\OfferRepository;
use App\Repositories\Addworking\Mission\ProposalResponseRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Database\Eloquent\refresh;
use Illuminate\Http\Request;

class ProposalResponseController extends Controller
{
    use HandlesIndex;

    protected $repository;

    protected $missionRepository;

    protected $offerRepository;

    public function __construct(
        ProposalResponseRepository $repository,
        MissionRepository $missionRepository,
        OfferRepository $offerRepository
    ) {
        $this->repository = $repository;
        $this->missionRepository = $missionRepository;
        $this->offerRepository = $offerRepository;
    }

    public function index(Enterprise $enterprise, Offer $offer, Proposal $proposal, Request $request)
    {
        $this->authorize('index', [ProposalResponse::class, $proposal]);

        $items = (auth()->user()->enterprise->is_vendor ? $proposal : $offer)->responses()->paginate(25);

        return view(
            $this->views['index'] ?? 'addworking.mission.proposal_response.index',
            @compact('offer', 'proposal', 'items')
        );
    }

    public function indexOfferAnswers(Enterprise $enterprise, Offer $offer, Request $request)
    {
        $this->authorize('index', $offer);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->ofOffer($offer)
            ->paginate(25);

        $numberOfResponses = $this->offerRepository->getNumberOfFinalValidatedResponses($offer);

        return view(
            $this->views['index'] ?? 'addworking.mission.proposal_response.index',
            @compact('offer', 'items', 'numberOfResponses')
        );
    }

    public function create(Enterprise $enterprise, Offer $offer, Proposal $proposal)
    {
        $this->authorize('create', [ProposalResponse::class, $proposal]);

        $response = $this->repository->factory()->proposal()->associate($proposal);

        return view($this->views['create']
            ?? 'addworking.mission.proposal_response.create', @compact('enterprise', 'offer', 'proposal', 'response'));
    }

    public function store(
        Enterprise $enterprise,
        Offer $offer,
        Proposal $proposal,
        StoreProposalResponseRequest $request
    ) {
        $this->authorize('store', [ProposalResponse::class, $proposal]);

        $response = $this->repository->createFromRequest($proposal, $request);

        return redirect_when($this->redirects['store'] ?? $response->exists, route(
            'enterprise.offer.proposal.response.show',
            ['enterprise' => $proposal->offer->customer,
            'offer'      => $proposal->mission_offer_id,
            'proposal'   => $proposal,
            'response'   => $response]
        ));
    }

    public function show(Enterprise $enterprise, Offer $offer, Proposal $proposal, ProposalResponse $response)
    {
        $this->authorize('show', [$response, $proposal]);

        $numberOfResponses = $this->offerRepository->getNumberOfFinalValidatedResponses($offer);

        return view(
            $this->views['show'] ?? 'addworking.mission.proposal_response.show',
            @compact('offer', 'proposal', 'response', 'numberOfResponses')
        );
    }

    public function edit(Enterprise $enterprise, Offer $offer, Proposal $proposal, ProposalResponse $response)
    {
        $this->authorize('edit', $response);

        return view('addworking.mission.proposal_response.edit', @compact('offer', 'proposal', 'response'));
    }

    public function update(
        Enterprise $enterprise,
        Offer $offer,
        Proposal $proposal,
        ProposalResponse $response,
        UpdateProposalResponseRequest $request
    ) {
        $this->authorize('update', $response);

        $response = $this->repository->updateFromRequest($response, $request);

        return redirect_when($this->redirects['update'] ?? $response->exists, route(
            'enterprise.offer.proposal.response.show',
            ['enterprise' => $proposal->offer->customer,
            'offer'      => $proposal->mission_offer_id,
            'proposal'   => $proposal,
            'response'   => $response]
        ));
    }

    public function destroy($id)
    {
        abort(501);
    }

    public function updateResponseStatus(
        Enterprise $enterprise,
        Offer $offer,
        Proposal $proposal,
        ProposalResponse $response,
        UpdateProposalResponseStatusRequest $request
    ) {
        $this->authorize('updateResponseStatus', $response);

        $this->repository->setStatus($response, $request);

        return $response->isFinalValidated() && $offer->refresh()->isClosed()
            ? redirect(route('enterprise.offer.summary', [$enterprise, $offer]))
            : redirect($response->routes->show);
    }

    public function mission(Enterprise $enterprise, Offer $offer, Proposal $proposal, ProposalResponse $response)
    {
        $this->authorize('mission', $response);

        $mission = $this->missionRepository->createFromProposalResponse($response);

        return redirect_when($mission->exists, route('enterprise.offer.summary', [$enterprise, $offer]));
    }
}
