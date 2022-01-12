<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Mission\Offer\Application\Models\Proposal;
use Components\Mission\Offer\Application\Notifications\SendOfferToEnterpriseNotification;
use Components\Mission\Offer\Domain\Exceptions\ProposalCreationFailedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ProposalEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ProposalRepositoryInterface;
use Illuminate\Support\Facades\Notification;

class ProposalRepository implements ProposalRepositoryInterface
{
    public function make(): ProposalEntityInterface
    {
        return new Proposal;
    }

    public function save(ProposalEntityInterface $proposal)
    {
        try {
            $proposal->save();
        } catch (ProposalCreationFailedException $exception) {
            throw $exception;
        }

        $proposal->refresh();

        return $proposal;
    }

    public function sendNotification(OfferEntityInterface $offer, Enterprise $enterprise)
    {
        Notification::send(
            $enterprise->users()->get(),
            new SendOfferToEnterpriseNotification($offer)
        );
    }

    public function hasProposalFor(OfferEntityInterface $offer, Enterprise $vendor): bool
    {
        return Proposal::whereHas('offer', function ($query) use ($offer) {
            return $query->where('id', $offer->getId());
        })->whereHas('vendor', function ($query) use ($vendor) {
            return $query->where('id', $vendor->id);
        })->exists();
    }

    public function getOfferProposals(OfferEntityInterface $offer)
    {
        return Proposal::whereHas('offer', function ($query) use ($offer) {
            return $query->where('id', $offer->getId());
        })->get();
    }
}
