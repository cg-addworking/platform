<?php

namespace Components\Mission\Mission\Domain\Interfaces\Entities;

use Components\Mission\Offer\Application\Models\Offer as SectorOffer;

interface MissionEntityInterface
{
    //STATUS
    const STATUS_DRAFT = 'draft';
    const STATUS_READY_TO_START = 'ready_to_start';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    const STATUS_CLOSED = 'closed';
    const STATUS_ABANDONED = 'abandoned';

    //UNIT
    const UNIT_HOURS = 'hours';
    const UNIT_DAYS = 'days';
    const UNIT_FIXED_FEES = 'fixed_fees';
    const UNIT_UNIT = 'unit';

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;
    public function setLabel($value): void;
    public function setStartsAt($value): void;
    public function setEndsAt($value): void;
    public function setDescription($value): void;
    public function setExternalId($value): void;
    public function setAnalyticCode($value): void;
    public function setCustomer($value): void;
    public function setVendor($value): void;
    public function setReferent($value): void;
    public function setWorkField($value): void;
    public function setCostEstimation($value): void;
    public function setDepartments(array $values): void;
    public function setStatus(string $value): void;
    public function setMilestoneType($value): void;
    public function setAmount(float $amount): void;

    public function unsetDepartments($values): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getLabel(): ?string;
    public function getStartsAt();
    public function getEndsAt();
    public function getDescription(): ?string;
    public function getDescriptionHtml(): ?string;
    public function getExternalId(): ?string;
    public function getAnalyticCode(): ?string;
    public function getStatus(): string;
    public function getWorkField();
    public function getCostEstimation();
    public function getCustomer();
    public function getVendor();
    public function getContract();
    public function getDepartments();
    public function getSectorOffer(): ?SectorOffer;
    public function getId(): string;
    public function getReferent();
    public function getFiles();
    public function getCreatedAt();
    public function getNumber();
    public function getMilestoneType(): ?string;
    public function getAmount(): ?float;
}
