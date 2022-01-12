<?php
namespace Components\Billing\Outbound\Domain\Classes;

use App\Models\Addworking\User\User;

interface OutboundInvoiceInterface
{
    const STATUS_PENDING         = "pending";
    const STATUS_FEES_CALCULATED = "fees_calculated";
    const STATUS_FILE_GENERATED  = "file_generated";
    const STATUS_PARTIALLY_PAID  = "partially_paid";
    const STATUS_FULLY_PAID      = "fully_paid";
    const STATUS_VALIDATED        = "validated";

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setMonth(string $month);
    public function setInvoicedAt(string $invoicedAt);
    public function setDueAt(string $dueAt);
    public function setEnterprise($enterprise);
    public function setDeadline($deadline);
    public function setStatus(string $status);
    public function setNumber();
    public function setValidateAt($validated_at);
    public function setFile($file);
    public function setLegalNotice(string $legalNotice);
    public function setReverseChargeVat(bool $reverseChargeVat);
    public function setParent($outboundInvoice);
    public function setValidatedBy(?User $user);
    public function setDaillyAssignment(bool $daillyAssignment);

    public function getReverseChargeVat(): bool;
    public function getDaillyAssignment(): bool;
    public function getStatus():? string;
    public function getMonth():? string;
    public function getDeadline();
    public function getNumber():? string;
    public function getId(): string;
    public function getFormattedNumber():? string;
    public function getAmountBeforeTaxes(): float;
    public function getAmountOfTaxes(): float;
    public function getAmountAllTaxesIncluded(): float;
    public function getEnterprise();
    public function getFile();
    public function getInvoicedAt();
    public function getDueAt();
    public function getPublishStatus(): bool;
    public function getLegalNotice():? string;
    public function getParent();
    public function getLabel(): string;
    public function getValidatedAt();
    public function getValidatedBy(): ?User;
}
