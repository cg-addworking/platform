<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Models\Mission;

interface ContractEntityInterface
{
    const STATUS_SIGNED            = "signed";
    const STATUS_PUBLISHED         = "published";
    const STATUS_DRAFT             = "draft";
    const STATUS_READY_TO_GENERATE = "ready_to_generate";
    const STATUS_GENERATING        = "generating";
    const STATUS_GENERATED         = "generated";
    const STATUS_UPLOADING         = "uploading";
    const STATUS_UPLOADED          = "uploaded";
    const STATUS_READY_TO_SIGN     = "ready_to_sign";
    const STATUS_BEING_SIGNED      = "being_signed";
    const STATUS_CANCELLED         = "cancelled";
    const STATUS_ACTIVE            = "active";
    const STATUS_INACTIVE          = "inactive";
    const STATUS_EXPIRED           = "expired";
    const STATUS_ERROR             = "error";
    const STATUS_DECLINED          = "declined";
    const STATUS_LOCKED            = "locked";
    const STATUS_UNKNOWN           = "unknown";

    const STATE_DRAFT = "draft";
    const STATE_TO_COMPLETE = "to_complete"; // deprecated v0.84.0
    const STATE_IN_PREPARATION = "in_preparation";
    const STATE_MISSING_DOCUMENTS = "missing_documents";
    const STATE_IS_READY_TO_GENERATE = "is_ready_to_generate";
    const STATE_GENERATING = "generating";
    const STATE_GENERATED = "generated";
    const STATE_TO_VALIDATE = "to_validate";
    const STATE_TO_SIGN = "to_sign";
    const STATE_DECLINED = "declined";
    const STATE_SIGNED = "signed";
    const STATE_ACTIVE = "active";
    const STATE_DUE = "due";
    const STATE_INACTIVE = "inactive";
    const STATE_CANCELED = "canceled";
    const STATE_UNKNOWN = "unknown";
    const STATE_ARCHIVED = "archived";
    // facades
    const STATE_WAITING_FOR_SIGNATURE  = "waiting_for_signature";
    const STATE_UNDER_VALIDATION       = "under_validation";
    const STATE_INTERNAL_VALIDATION    = "internal_validation";
    // facades

    const SEARCHABLE_ATTRIBUTE_NAME = 'name';
    const SEARCHABLE_ATTRIBUTE_EXTERNAL_IDENTIFIER = 'external_identifier';
    const SEARCHABLE_ATTRIBUTE_NUMBER = "number";
    const SEARCHABLE_ATTRIBUTE_WORKFIELD_EXTERNAL_IDENTIFIER = "workfield.external_id";
    const SEARCHABLE_ATTRIBUTE_CONTRACT_PARTY_ENTERPRISE_NAME = "parties.enterprise.name";

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setEnterprise($enterprise);
    public function setContractModel(ContractModelEntityInterface $contract_model);
    public function setParent(ContractEntityInterface $contract);
    public function setWorkfield(WorkField $workfield);
    public function setMission(Mission $mission);
    public function setNextPartyToSign(?ContractPartyEntityInterface $contract_party);
    public function setNextPartyToValidate(?ContractPartyEntityInterface $contract_party);
    public function setName(string $name);
    public function setNumber();
    public function setValidFrom(?string $valid_from);
    public function setValidUntil(?string $valid_until);
    public function setExternalIdentifier(?string $external_identifier);
    public function setStatus(string $status);
    public function setState(string $state);
    public function setInactiveAt($inactive_at);
    public function setCanceledAt($canceled_at);
    public function setYousignProcedureId(?string $id): void;
    public function setSentToSignatureAt($sent_to_signature_at);
    public function setCreatedBy(?User $created_by): void;
    public function setSentToSignatureBy(?User $sent_to_signature_by): void;
    public function setDeletedBy(User $user): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getEnterprise(): ?Enterprise;
    public function getSubcontractingDeclaration();
    public function getContractModel(): ?ContractModelEntityInterface;
    public function getContractVariables();
    public function getParties();
    public function getParent(): ?ContractEntityInterface;
    public function getAmendments();
    public function getNextPartyToSign(): ?ContractPartyEntityInterface;
    public function getNextPartyToValidate(): ?ContractPartyEntityInterface;
    public function getWorkfield(): ?WorkField;
    public function getId(): string;
    public function getName(): ?string;
    public function getValidFrom();
    public function getValidUntil();
    public function getStatus();
    public function getState();
    public function getNumber(): ?int;
    public function getExternalIdentifier(): ?string;
    public function isPublished();
    public function getDeletedAt();
    public function getParts();
    public function isSigned();
    public function getInactiveAt();
    public function getCanceledAt();
    public function getYousignProcedureId(): ?string;
    public function getMission(): ?Mission;
    public function getSentToSignatureAt();
    public function getCreatedBy(): ?User;
    public function getSentToSignatureBy(): ?User;
    public function getCreatedAt();
    public function getDeletedBy(): ?User;
}
