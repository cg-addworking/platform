<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Mission\Offer\AcceptOfferNotification;
use App\Notifications\Addworking\Mission\Offer\PendingOfferNotification;
use App\Notifications\Addworking\Mission\Offer\RefuseOfferNotification;
use App\Notifications\Addworking\Mission\RequestCloseOfferNotification;
use App\Notifications\Mission\Proposal\Send;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class OfferRepository extends BaseRepository
{
    protected $model = Offer::class;

    public function createFromRequest(Request $request): Offer
    {
        return tap($this->make($request->input('mission_offer')), function ($offer) use ($request) {
            $offer->customer()->associate($request->input('customer.id'))
                ->createdBy()->associate($request->user())
                ->referent()->associate($request->input('mission_offer.referent_id'))
                ->save();

            $offer->departments()->attach($request->input('department.id'));
            $offer->files()->attach($this->getFilesFromRequest($request)->pluck('id'));
            $offer->skills()->attach($request->input('mission_offer.skills'));
        });
    }

    public function updateFromRequest(Offer $offer, Request $request): Offer
    {
        return tap($offer->fill($request->input('mission_offer')), function ($offer) use ($request) {
            $offer->referent()->associate($request->input('mission_offer.referent_id'))->save();
            $offer->departments()->sync($request->input('department.id'));
            $offer->files()->sync($this->getFilesFromRequest($request)->pluck('id'));
            $offer->skills()->sync($request->input('mission_offer.skills'));
        });
    }

    protected function getFilesFromRequest(Request $request): Collection
    {
        $files = new Collection;

        foreach ($request->file('mission_offer.file') ?? [] as $file) {
            $files->push(
                tap(File::from($file), function ($file) {
                    $file->name("/%uniq%-%ts%.%ext%")->save();
                })
            );
        }

        return $files;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Offer::query()
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->filterCreatedAt($date);
            })
            ->when($filter['label'] ?? null, function ($query, $label) {
                return $query->filterLabel($label);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['referent'] ?? null, function ($query, $referent) {
                return $query->filterReferent($referent);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function resendOfferProposals(Offer $offer)
    {
        return $offer->proposals->filter(function ($proposal) use ($offer) {
            return ! $proposal->vendor->proposals()->has('responses')->ofOffer($offer)->exists();
        })->each(function ($proposal) {
            Notification::send($proposal->vendor->users, new Send($proposal));
        });
    }

    public function handleProposalsNotificationsAfterClosingOffer(Offer $offer)
    {
        return $offer->proposals->each(function ($proposal) use ($offer) {
            if ($proposal->isAccepted()) {
                Notification::send(
                    $proposal->vendor->legalRepresentatives,
                    new AcceptOfferNotification($offer, $proposal)
                );
            }

            if ($proposal->isUnderNegotiation() || $proposal->isRefused()) {
                Notification::send(
                    $proposal->vendor->legalRepresentatives,
                    new RefuseOfferNotification($offer)
                );
            }

            if (is_null($proposal->responses->first())) {
                Notification::send(
                    $proposal->vendor->legalRepresentatives,
                    new PendingOfferNotification($offer)
                );
            }
        });
    }

    public function close(Offer $offer): bool
    {
        $this->handleProposalsNotificationsAfterClosingOffer($offer);

        return $offer->update(['status' => Offer::STATUS_CLOSED]);
    }

    public function sendRequestClose(string $email, User $sender, Offer $offer)
    {
        Notification::route(
            'mail',
            $email
        )->notify(
            new RequestCloseOfferNotification($sender, $offer)
        );
    }

    public function getNumberOfFinalValidatedResponses(Offer $offer)
    {
        $numberOfFinalValidatedResponses = 0;

        $offer->proposals()->each(function (Proposal $proposal) use (&$numberOfFinalValidatedResponses) {
            $numberOfFinalValidatedResponses += $proposal->responses()
                ->where('status', ProposalResponse::STATUS_FINAL_VALIDATION)->count();
        });

        return $numberOfFinalValidatedResponses;
    }

    public function getUsersAbleToCloseOffer(Offer $offer)
    {
        return $offer->customer->users()->where('is_mission_offer_closer', true);
    }

    public function checkIfUserCanAccessTo(User $user, Offer $offer)
    {
        return $offer->customer->users->contains($user)
            && $user->hasRoleFor($offer->customer, [User::ROLE_MISSION_OFFER_BROADCASTER]);
    }
}
