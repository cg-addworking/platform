<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use DateTime;

interface WorkFieldEntityInterface
{
    const SEARCHABLE_ATTRIBUTE_NAME = 'name';
    const SEARCHABLE_ATTRIBUTE_EXTERNAL_IDENTIFIER = 'external_id';
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber():void;
    public function setName(string $name): void;
    public function setDisplayName(string $display_name): void;
    public function setDescription(?string $description): void;
    public function setEstimatedBudget(?float $estimated_budget): void;
    public function setStartedAt(?string $started_at): void;
    public function setEndedAt(?string $ended_at): void;
    public function setOwner($enterprise): void;
    public function setCreatedBy($user): void;
    public function setExternalId(?string $external_id): void;
    public function setAddress(?string $address): void;
    public function setProjectManager(?string $project_manager): void;
    public function setProjectOwner(?string $project_owner): void;
    public function setArchivedAt(): void;
    public function setArchivedBy($user): void;
    public function setDepartments(array $values): void;
    public function unsetDepartments($values): void;
    public function setSpsCoordinator(?string $sps_coordinator): void;
    public function setContracts(array $contracts): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string;
    public function getCreatedAt(): DateTime;
    public function getUpdatedAt(): DateTime;
    public function getNumber():int;
    public function getName(): string;
    public function getDisplayName(): ?string;
    public function getDescription(): ?string;
    public function getDescriptionHtml(): ?string;
    public function getEstimatedBudget(): ?float;
    public function getStartedAt(): ?DateTime;
    public function getEndedAt(): ?DateTime;
    public function getArchivedAt(): ?DateTime;
    public function getArchivedBy(): User;
    public function getDepartments();
    public function getOwner(): Enterprise;
    public function getCreatedBy(): ?User;
    public function getDeletedBy(): User;
    public function getWorkFieldContributors();
    public function getExternalId(): ?string;
    public function getAddress(): ?string;
    public function getProjectManager(): ?string;
    public function getProjectOwner(): ?string;
    public function getSpsCoordinator(): ?string;
    public function getContracts();
}
