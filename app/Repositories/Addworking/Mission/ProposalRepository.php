<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Mission\ProposalIsInterestingForVendorNotification;
use App\Notifications\Mission\Proposal\Send;
use App\Repositories\Addworking\Common\CommentRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\InvitationRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProposalRepository extends BaseRepository
{
    protected $model = Proposal::class;
    protected $offer;
    protected $enterprise;
    protected $comment;
    protected $invitationRepository;

    public function __construct(
        OfferRepository $offer,
        EnterpriseRepository $enterprise,
        CommentRepository $comment,
        InvitationRepository $invitationRepository
    ) {
        $this->offer = $offer;
        $this->enterprise = $enterprise;
        $this->comment = $comment;
        $this->invitationRepository = $invitationRepository;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Proposal::query()
            ->when($filter['label'] ?? null, function ($query, $label) {
                return $query->filterLabel($label);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter['referent'] ?? null, function ($query, $referent) {
                return $query->filterReferent($referent);
            })
            ->when($filter['starts_at_desired'] ?? null, function ($query, $date) {
                return $query->filterStartsAtDesired($date);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request): Collection
    {
        return DB::transaction(function () use ($request) {
            $offer = $this->offer->find($request->input('mission_offer.id'));

            $vendors = Collection::wrap($request->input('vendor.id'))->filter(function ($vendor_id) use ($offer) {
                $vendor = $this->enterprise->find($vendor_id);
                if (! $vendor->proposals()->ofOffer($offer)->exists()) {
                    return $vendor_id;
                } else {
                    if (! $vendor->proposals()->has('responses')->ofOffer($offer)->exists()) {
                        $proposal = $vendor->proposals()->ofOffer($offer)->first();
                        Notification::send($vendor->users, new Send($proposal));
                    };
                };
            });

            $proposals = $vendors->map(fn($vendor) => $this->createProposal(
                $offer,
                $this->enterprise->find($vendor),
                $request->input('mission_proposal'),
                $request->user()
            ));

            if ($request->input('mission_proposal.send_invitation', 'off') === 'on') {
                $this->invitationRepository->sendVendorInvitationForMissionProposal($offer->customer->id, [
                    'offer_id' => $offer->id,
                    'mission_proposal' => $request->input('mission_proposal'),
                    'created_by' => $request->user()->id
                ]);
            }

            $offer->update(['status' => Offer::STATUS_COMMUNICATED]);
            return $proposals;
        });
    }

    public function createProposal(
        Offer $offer,
        Enterprise $vendor,
        array $mission_proposal,
        User $creator,
        bool $notify = true
    ): Proposal {
        /** @var Proposal $proposal */
        if (! is_null($mission_proposal['valid_from'])) {
            $mission_proposal['valid_from'] = DateTime::createFromFormat('Y-m-d', $mission_proposal['valid_from']);
        }

        if (! is_null($mission_proposal['valid_until'])) {
            $mission_proposal['valid_until'] = DateTime::createFromFormat('Y-m-d', $mission_proposal['valid_until']);
        }

        $proposal = $this->make(['label' => $offer->label] + $mission_proposal);
        $proposal->vendor()->associate($vendor);
        $proposal->createdBy()->associate($creator);
        $proposal->offer()->associate($offer);
        $proposal->save();

        if ($notify) {
            Notification::send($proposal->vendor->users, new Send($proposal));
        }

        return $proposal;
    }

    public function setStatus(Proposal $proposal, Request $request): Proposal
    {
        return DB::transaction(function () use ($proposal, $request) {
            $oldStatus = $proposal->status;
            $proposal->update($request->input('proposal'));

            $this->comment->createFromRequest($request);

            switch ($proposal->status) {
                case Proposal::STATUS_INTERESTED && $oldStatus === Proposal::STATUS_RECEIVED:
                    Notification::send(
                        $proposal->offer->referent,
                        new ProposalIsInterestingForVendorNotification($proposal)
                    );
                    break;
            }

            return $proposal;
        });
    }

    public function isExpired(Proposal $proposal): bool
    {
        if (is_null($proposal->valid_until)) {
            return false;
        }

        return Carbon::parse($proposal->valid_until)->lessThan(Carbon::now());
    }
}
