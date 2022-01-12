<?php

namespace Components\Mission\Offer\Domain\Interfaces\Entities;

interface ResponseEntityInterface
{
    const STATUS_PENDING = 'pending';
    const STATUS_REFUSED = 'refused';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_NOT_SELECTED = 'not_selected';

    const SEARCHABLE_ATTRIBUTE_ENTERPRISE_NAME = 'enterprise.name';

    public function setStartsAt($value): void;
    public function setEndsAt($value): void;
    public function setAmountBeforeTaxes($value): void;
    public function setArgument($value): void;
    public function setStatus($value): void;
    public function setNumber(): void;
    public function setOffer($value): void;
    public function setCreatedBy($value): void;
    public function setFile($value): void;
    public function setEnterprise($value): void;

    public function getStatus(): string;
    public function getStartsAt();
    public function getEndsAt();
    public function getCreatedBy();
    public function getOffer();
    public function getEnterprise();
    public function getCreatedAt();
    public function getAmountBeforeTaxes(): float;
}
