<?php

namespace Components\Mission\Offer\Domain\Interfaces\Entities;

interface ProposalEntityInterface
{
    public function setOffer($offer): void;
    public function setVendor($vendor): void;
    public function setCreatedBy($user): void;
    public function setNumber();
    public function getOffer() : OfferEntityInterface;
    public function getVendor();
    public function getCreatedBy();
    public function getCreatedAt();
    public function getNumber(): ?int;
}
