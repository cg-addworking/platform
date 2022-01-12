<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Notifications\Addworking\Mission\Offer\AcceptOfferNotification;
use App\Notifications\Addworking\Mission\ProposalResponseCreatedNotification;
use App\Notifications\Addworking\Mission\ProposalResponseIsOkToMeetNotification;
use App\Repositories\Addworking\Common\CommentRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

class ProposalResponseRepository extends BaseRepository
{
    protected $model = ProposalResponse::class;

    protected $comment;

    protected $user;

    protected $offer;

    public function __construct(
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        OfferRepository $offerRepository
    ) {
        $this->comment = $commentRepository;
        $this->user    = $userRepository;
        $this->offer   = $offerRepository;
    }

    public function createFromRequest(Proposal $proposal, Request $request): ProposalResponse
    {
        return DB::transaction(function () use ($proposal, $request) {

            $response = new ProposalResponse;
            $response->fill($request->input('response'));
            $response->proposal()->associate($proposal->id);
            $response->createdBy()->associate($request->user());
            $response->save();
            $response->files = $request->file('response.files');

            $proposal->update(['status' => Proposal::STATUS_ANSWERED]);

            Notification::send(
                $this->user->find($proposal->offer->referent_id),
                new ProposalResponseCreatedNotification($response)
            );

            return $response;
        });
    }

    public function updateFromRequest(ProposalResponse $response, Request $request): ProposalResponse
    {
        $response->update($request->input('response'));

        return $response;
    }

    public function setStatus(ProposalResponse $response, Request $request): ProposalResponse
    {
        return DB::transaction(function () use ($response, $request) {
            $response->fill($request->input('response'))->save();

            $this->addCommentToStatus($response, $request);

            switch ($response->status) {
                case ProposalResponse::STATUS_REFUSED:
                    $response->refusedBy()->associate($request->user());
                    $response->refused_at = Carbon::now();
                    $response->save();
                    $response->proposal->update(['status' => Proposal::STATUS_REFUSED]);
                    break;

                case ProposalResponse::STATUS_FINAL_VALIDATION:
                    $response->acceptedBy()->associate($request->user());
                    $response->accepted_at = Carbon::now();
                    $response->save();
                    $response->proposal->update(['status' => Proposal::STATUS_ACCEPTED]);
                    break;

                case ProposalResponse::STATUS_OK_TO_MEET:
                    if ($response->proposal->offer->referent->exists) {
                        Notification::send(
                            $response->proposal->offer->referent,
                            new ProposalResponseIsOkToMeetNotification($response)
                        );
                    }
                    break;

                case ProposalResponse::STATUS_INTERVIEW_REQUESTED:
                case ProposalResponse::STATUS_INTERVIEW_POSITIVE:
                    $response->proposal->update(['status' => Proposal::STATUS_UNDER_NEGOTIATION]);
                    break;
            }

            if ($request->has('close_mission_offer')) {
                if (! $this->offer->close($response->proposal->offer)) {
                    throw new RuntimeException("unable to close offer");
                }
            }

            return $response;
        });
    }

    public function addCommentToStatus(ProposalResponse $response, Request $request)
    {
        $this->comment->createFromRequest(
            $request,
            "Passage au statut '".__('mission.response.status.'.$response->status)."'"
        );
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return ProposalResponse::query()
            ->when($filter['label'] ?? null, function ($query, $label) {
                return $query->filterLabel($label);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->filterCreatedAt($date);
            });
    }

    public function countProposalResponsesOf(Proposal $proposal)
    {
        return ProposalResponse::whereHas('proposal', function ($query) use ($proposal) {
            return $query->whereHas('offer', function ($query) use ($proposal) {
                return $query->where('id', $proposal->offer->id);
            })->whereHas('vendor', function ($query) use ($proposal) {
                return $query->where('id', $proposal->vendor->id);
            });
        })->count();
    }
}
