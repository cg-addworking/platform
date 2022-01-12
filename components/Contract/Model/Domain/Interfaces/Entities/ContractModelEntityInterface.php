<?php

namespace Components\Contract\Model\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;

interface ContractModelEntityInterface
{
    const STATUS_DRAFT            = "Draft";
    const STATUS_PUBLISHED        = "Published";
    const STATUS_ARCHIVED         = "Archived";

    const SEARCHABLE_ATTRIBUTE_DISPLAY_NAME = 'display_name';

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setEnterprise($enterprise);
    public function setDisplayName(string $display_name);
    public function setName(string $display_name);
    public function setNumber();
    public function setPublishedAt();
    public function setPublishedBy($user);
    public function setDuplicatedFrom($model);
    public function setShouldVendorsFillTheirVariables(bool $should_vendors_fill_their_variables): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string;
    public function getDisplayName(): ?string;
    public function getEnterprise(): ?Enterprise;
    public function getNumber(): int;
    public function getCreatedAt();
    public function getUpdatedAt();
    public function getDeletedAt();
    public function getPublishedAt();
    public function getArchivedAt();
    public function getParties();
    public function getParts();
    public function getVariables();
    public function getStatus(): string;
    public function getDuplicatedFrom();
    public function getContracts();
    public function getShouldVendorsFillTheirVariables(): ?bool;
}
