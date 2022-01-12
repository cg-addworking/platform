<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Entities;

interface WorkFieldContributorEntityInterface
{
    const ROLE_BUYER = "buyer";
    const ROLE_OPERATIONAL_MANAGER = "operational_manager";
    const ROLE_SUPERVISOR = "supervisor";
    const ROLE_RESPONSIBLE_QHSE = "responsible_qhse";
    const ROLE_AUDITOR = "auditor";
    const ROLE_OBSERVER = "observer";

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;
    public function setIsAdmin(bool $is_admin): void;
    public function setIsContractValidator(bool $is_contract_validator): void;
    public function setContractValidationOrder(int $contract_validation_order): void;
    public function setEnterprise($enterprise);
    public function setContributor($contributor);
    public function setWorkField($work_field);
    public function setRole(?string $role): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getIsAdmin(): bool;
    public function getIsContractValidator(): bool;
    public function getContractValidationOrder(): int;
    public function getContributor();
    public function getEnterprise();
    public function getWorkField();
    public function getId();
}
