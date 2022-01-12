<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\Offer\StoreMissionOfferRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Mission\Offer\AcceptOfferNotification;
use App\Notifications\Addworking\Mission\Offer\PendingOfferNotification;
use App\Notifications\Addworking\Mission\Offer\RefuseOfferNotification;
use App\Notifications\Mission\Proposal\Send;
use App\Repositories\Addworking\Common\JobRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\Mission\OfferRepository;
use App\Repositories\Addworking\User\UserRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class OfferController extends Controller
{
    use HandlesIndex;

    protected $repository;
    protected $missionRepository;
    protected $userRepository;
    protected $jobRepository;

    public function __construct(
        OfferRepository $repository,
        MissionRepository $missionRepository,
        UserRepository $userRepository,
        JobRepository $jobRepository
    ) {
        $this->repository   = $repository;
        $this->missionRepository = $missionRepository;
        $this->userRepository    = $userRepository;
        $this->jobRepository     = $jobRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Offer::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request) {
            $enterprise = $request->user()->enterprise;

            $query
                ->when($enterprise->is_customer
                    && $enterprise->is_vendor
                    && !$request->user()->isSupport(), function ($q) use ($enterprise) {
                        $q->havingProposalsForVendorCustomer($enterprise);
                    })
                ->when($enterprise->is_vendor
                    && !$enterprise->is_customer
                    && !$request->user()->isSupport(), function ($q) use ($enterprise) {
                        $q->havingProposalsForVendor($enterprise)->exceptDraft();
                    })
                ->when($enterprise->is_customer
                    && !$enterprise->is_vendor
                    && !$request->user()->isSupport(), function ($q) use ($enterprise) {
                        $q->havingProposalsForCustomer($enterprise);
                    });
        }, $this->repository);

        return view($this->views['index'] ?? 'addworking.mission.offer.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', Offer::class);

        $offer     = $this->repository->factory();
        $customers = $this->missionRepository->getAvailableCustomers(auth()->user())->pluck('name', 'id');
        $jobs      = $this->jobRepository->getJobsFromAllAncestors(auth()->user()->enterprise, true);

        return view($this->views['create'] ?? 'addworking.mission.offer.create', compact('offer', 'customers', 'jobs'));
    }

    public function store(StoreMissionOfferRequest $request)
    {
        // This validation is not in the request
        // because StoreMissionOfferRequest is
        // shared with another Controller which
        // doesn't handle mission_offer.label
        $request->validate([
            'mission_offer.label' => 'required|string|max:255',
        ]);

        $offer = $this->repository->createFromRequest($request);

        $auth_user = $this->userRepository->connectedUser();

        if ($offer) {
            if ($offer->status != offer::STATUS_DRAFT && ($auth_user->isSupport()
                || App::make(OfferRepository::class)->checkIfUserCanAccessTo($auth_user, $offer))) {
                return redirect()
                    ->route($this->redirects['store'] ?? 'enterprise.offer.profile.create', [$offer->customer, $offer])
                    ->with(success_status(__('addworking.mission.offer.create.success_creation')));
            } else {
                return redirect()->route($this->redirects['store'] ?? 'mission.offer.show', $offer)
                    ->with(success_status(__('addworking.mission.offer.create.success_creation')));
            }
        } else {
            return redirect()->back()->with(error_status());
        }
    }

    public function show(Offer $offer)
    {
        $this->authorize('show', $offer);

        $numberOfResponses = $this->repository->getNumberOfFinalValidatedResponses($offer);

        return view($this->views['show'] ?? 'addworking.mission.offer.show', @compact('offer', 'numberOfResponses'));
    }

    public function edit(Offer $offer)
    {
        $this->authorize('edit', $offer);

        $customers =  $this->missionRepository->getAvailableCustomers(auth()->user())->pluck('name', 'id');

        return view($this->views['edit'] ?? 'addworking.mission.offer.edit', @compact('offer', 'customers'));
    }

    public function update(Request $request, Offer $offer)
    {
        $this->authorize('update', $offer);

        $offer = $this->repository->updateFromRequest($offer, $request);

        return $offer
            ? redirect()->route($this->redirects['update'] ?? 'mission.offer.show', $offer)
                ->with(success_status('Offre de mission enregistrée avec succès'))
            : redirect()->back()->with(error_status());
    }

    public function destroy(Offer $offer)
    {
        $this->authorize('destroy', $offer);

        $deleted = $offer->delete();

        return $deleted
            ? redirect()->route($this->redirects['destroy'] ?? 'mission.offer.index')
                ->with(success_status("Offre de mission supprimée avec succès"))
            : redirect()->back()->with(error_status());
    }

    public function close(Enterprise $enterprise, Offer $offer)
    {
        $this->authorize('close', $offer);

        $closed = $this->repository->close($offer);

        return redirect_when($closed, route('enterprise.offer.summary', [
            'enterprise'  => $offer->customer,
            'offer' => $offer
        ]));
    }

    public function requestClose(Enterprise $enterprise, Offer $offer)
    {
        $usersCanCloseOffer = $this->repository->getUsersAbleToCloseOffer($offer);

        $numberOfResponses = $this->repository->getNumberOfFinalValidatedResponses($offer);

        return view(
            'addworking.mission.offer.send_request_close',
            @compact('enterprise', 'offer', 'usersCanCloseOffer', 'numberOfResponses')
        );
    }

    public function sendRequestClose(Request $request, Enterprise $enterprise, Offer $offer)
    {
        $this->authorize('sendRequestClose', $offer);

        $email = $this->userRepository->findEmail($request->input('member'));

        $sender = $request->user();

        $this->repository->sendRequestClose($email, $sender, $offer);

        return redirect()->route('mission.offer.show', $offer)
            ->with(success_status("Demande de clôture envoyée avec succès"));
    }

    public function summary(Enterprise $enterprise, Offer $offer)
    {
        $this->authorize('summary', $offer);

        $items = $offer->responses->sortBy('status');

        return view('addworking.mission.offer.summary', @compact('offer', 'items'));
    }

    public function resendProposal(Offer $offer)
    {
        $this->authorize('resendProposal', $offer);

        $proposals = $this->repository->resendOfferProposals($offer);

        return redirect()->back()->with(success_status($proposals->count() . " proposition(s) ont été renvoyés !"));
    }

    public function assignIndex(Enterprise $enterprise, Offer $offer)
    {
        $this->authorize('assign', $offer);

        $items = [];

        return view(
            $this->views['assign'] ?? 'addworking.mission.offer.assign',
            @compact('enterprise', 'offer', 'items')
        );
    }

    public function assignStore(Enterprise $enterprise, Offer $offer, Enterprise $vendor, Request $request)
    {
        $this->authorize('assign', $offer);

        $mission = $this->missionRepository->createFromOffer($offer, $vendor, $request);

        return $this->redirectWhen($mission->exists, $mission->routes->show, 'Mission créee avec succés');
    }
}
