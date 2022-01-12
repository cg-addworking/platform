<?php

namespace Components\Mission\Offer\Domain\Interfaces\Entities;

interface OfferEntityInterface
{
    const STATUS_DRAFT = 'draft';
    const STATUS_TO_PROVIDE = 'to_provide';
    const STATUS_COMMUNICATED = 'communicated';
    const STATUS_CLOSED = 'closed';
    const STATUS_ABANDONED = 'abandoned';

    const SEARCHABLE_ATTRIBUTE_LABEL = 'label';
    const SEARCHABLE_ATTRIBUTE_CUSTOMER_NAME = 'customer.name';
    const SEARCHABLE_ATTRIBUTE_REFERENT_LASTNAME = 'referent.lastname';

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;
    public function setLabel($value): void;
    public function setStartsAtDesired($value): void;
    public function setEndsAt($value): void;
    public function setDescription($value): void;
    public function setExternalId($value): void;
    public function setAnalyticCode($value): void;
    public function setCreatedBy($value): void;
    public function setCustomer($value): void;
    public function setReferent($value): void;
    public function setWorkField($value): void;
    public function setDepartments(array $values): void;
    public function setSkills(array $values): void;
    public function setStatus(string $value): void;
    public function setResponseDeadline($value): void;

    public function unsetDepartments($values): void;
    public function unsetSkills($values): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getLabel(): ?string;
    public function getStartsAtDesired();
    public function getEndsAt();
    public function getDescription(): ?string;
    public function getDescriptionHtml(): ?string;
    public function getExternalId(): ?string;
    public function getAnalyticCode(): ?string;
    public function getStatus(): string;
    public function getWorkField();
    public function getCustomer();
    public function getDepartments();
    public function getSkills();
    public function getProposals();
    public function getId(): string;
    public function getReferent();
    public function getResponses();
    public function getFiles();
    public function getNumber();
    public function getResponseDeadline();
}
