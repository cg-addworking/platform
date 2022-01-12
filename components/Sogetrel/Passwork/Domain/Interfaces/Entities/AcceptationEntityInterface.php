<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Entities;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use DateTime;

interface AcceptationEntityInterface
{
    const SEARCHABLE_ATTRIBUTE_ACCEPTED_BY_NAME = 'accepted_by_name';
    const SEARCHABLE_ATTRIBUTE_OPERATIONAL_MANAGER_NAME = 'operational_manager_name';
    const SEARCHABLE_ATTRIBUTE_ENTERPRISE_NAME = 'enterprise.name';

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;

    public function setSogetrelPasswork(SogetrelPasswork $passwork): void;

    public function setEnterprise(Enterprise $enterprise): void;

    public function setContractStartingAt(DateTime $contract_starting_at): void;

    public function setContractEndingAt(DateTime $contract_ending_at): void;

    public function setAcceptedBy(User $accepted_by): void;

    public function setAcceptedByName(string $accepted_by_name): void;

    public function setOperationalManager(User $operational_manager): void;

    public function setOperationalManagerName(string $operational_manager_name): void;

    public function setAdministrativeAssistant(User $administrative_assistant): void;

    public function setAdministrativeAssistantName(string $administrative_assistant_name): void;

    public function setAdministrativeManager(User $administrative_manager): void;

    public function setAdministrativeManagerName(string $administrative_manager_name): void;

    public function setContractSignatory(User $contract_signatory): void;

    public function setContractSignatoryName(string $contract_signatory_name): void;

    public function setAcceptationComment(Comment $comment): void;

    public function setOperationalMonitoringDataComment(Comment $comment): void;

    public function setNeedsDecennialInsurance(bool $needs_decennial_insurance): void;

    public function setApplicablePriceSlip(string $applicable_price_slip): void;

    public function setBankGuaranteeAmount(?float $bank_guarantee_amount): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getSogetrelPasswork(): SogetrelPasswork;

    public function getEnterprise(): Enterprise;

    public function getAcceptedBy(): ?User;

    public function getAcceptedByName(): string;

    public function getCreatedAt(): ?DateTime;

    public function getOperationalManager(): ?User;

    public function getOperationalManagerName(): string;

    public function getAdministrativeAssistant(): ?User;

    public function getAdministrativeAssistantName(): string;

    public function getAdministrativeManager(): ?User;

    public function getAdministrativeManagerName(): string;

    public function getContractSignatory(): ?User;

    public function getContractSignatoryName(): string;

    public function getNeedsDecennialInsurance(): bool;

    public function getApplicablePriceSlip(): string;

    public function getBankGuaranteeAmount(): ?float;

    public function getContractStartingAt(): ?DateTime;

    public function getContractEndingAt(): ?DateTime;

    public function getAcceptationComment(): ?Comment;

    public function getOperationalMonitoringDataComment(): ?Comment;
}
