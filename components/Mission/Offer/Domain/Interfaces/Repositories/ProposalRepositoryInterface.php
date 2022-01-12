<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ProposalEntityInterface;

interface ProposalRepositoryInterface
{
    public function make(): ProposalEntityInterface;
    public function save(ProposalEntityInterface $proposal);
    public function sendNotification(OfferEntityInterface $offer, Enterprise $enterprise);
    public function hasProposalFor(OfferEntityInterface $offer, Enterprise $vendor): bool;
    public function getOfferProposals(OfferEntityInterface $offer);
}
