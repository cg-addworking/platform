<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ContractRepositoryInterface
{
    public function find(string $id): ?ContractEntityInterface;
    public function make($data = []): ContractEntityInterface;
    public function save(ContractEntityInterface $contract);
    public function list(
        User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function countContractsOfState(User $user, ?string $state = null);
    public function findByNumber(string $number, ?bool $trashed = null): ?ContractEntityInterface;
    public function getAvailableStatuses();
    public function getAvailableStates(bool $trans = false): array;
    public function listAsSupport(
        ?User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function listAsSupportForEnterprise(
        Enterprise $enterprise,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null
    );
    public function getPartiesWithoutOwner(ContractEntityInterface $contract);
    public function isDraft(ContractEntityInterface $contract): bool;
    public function delete(ContractEntityInterface $contract): bool;
    public function isDeleted(int $number): bool;
    public function isPartyOf(User $user, ContractEntityInterface $contract): bool;
    public function isVendorAndPartyOf(User $user, ContractEntityInterface $contract): bool;
    public function isValidatorOf(User $user, ContractEntityInterface $contract): bool;
    public function isCreator(User $user, ContractEntityInterface $contract): bool;
    public function sendNotificationRequestDocuments(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        $is_followup = true
    );
    public function sendNotificationRequestContractVariableValue(
        ContractEntityInterface $contract,
        $user_to_request,
        $url
    );
    public function sendNotificationToSignContract(
        Contract $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ): bool;
    public function sendNotificationToValidateContractOnYousign(
        Contract $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ): bool;
    public function sendNotificationToSendContractToSignature(Contract $contract): bool;
    public function isReadyToGenerate(ContractEntityInterface $contract): bool;
    public function checkIfAllDocumentsOfContractStatusIsValidated(ContractEntityInterface $contract): bool;
    public function checkIfAllDocumentsOfContractStatusIsValidatedForParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    ): bool;
    public function isOwnerOf(User $auth_user, ContractEntityInterface $contract): bool;
    public function generate(ContractEntityInterface $contract) : string;
    public function isAmendment(ContractEntityInterface $contract): bool;
    public function hasActiveAmendment(ContractEntityInterface $contract): bool;
    public function updateStatus(ContractEntityInterface $contract, string $status);
    public function checkIfContractIsSigned(ContractEntityInterface $contract): bool;
    public function checkIfContractIsDeclined(ContractEntityInterface $contract): bool;
    public function checkIfAllPartiesHasSignatory(ContractEntityInterface $contract): bool;
    public function canSign(ContractEntityInterface $contract, User $user): bool;
    public function checkIfHasPartsWithContractModel(ContractEntityInterface $contract): bool;
    public function getValidUntilDate(ContractEntityInterface $contract);
    public function findByYousignProcedureId(string $id): ?ContractEntityInterface;
    public function getSearchableAttributes(): array;
    public function checkIfStateIsSigned(ContractEntityInterface $contract): bool;
    public function getContractParts(
        ContractEntityInterface $contract,
        bool $without_hidden = false,
        bool $hidden_only = false
    );
    public function getNonBodyContractPart(ContractEntityInterface $contract);
    public function orderContractParts(ContractEntityInterface $contract): void;
    public function hasYousignProcedureId(ContractEntityInterface $contract): bool;
    public function hasContractModel(ContractEntityInterface $contract);
    public function isDateActive(ContractEntityInterface $contract): bool;
    public function isDateDue(ContractEntityInterface $contract): bool;
    public function canBeRegenerated(ContractEntityInterface $contract): bool;
    public function getSignatoryParties(ContractEntityInterface $contract);
    public function getValidatorParties(ContractEntityInterface $contract);
    public function getPendingValidatorParties(ContractEntityInterface $contract);
    public function getContractsBetween($enterprises, bool $without_mission = false);
    public function getDocumentOfContractModelDocumentType(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        ContractModelDocumentType $type
    );
    public function sendNotificationForSignedContract(Contract $contract, User $user);
    public function sendNotificationForRefusedContract(Contract $contract, User $user);
    public function checkIfSendNotificationDocumentsToParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    ): bool;
    public function getDocumentOfDocumentType(
        ContractModelDocumentType $type,
        ContractPartyEntityInterface $contract_party
    );
    public function download(ContractEntityInterface $contract);
    public function getWorkFieldsAttachedToContract();
    public function getContractFacadeState(ContractEntityInterface $contract, ?User $user = null): ?string;
    public function checkIfUserCanCallBackContract(User $user, Contract $contract): bool;
    public function getWorkfieldOf(ContractEntityInterface $contract): ?WorkField;
    public function getContractDocumentActions(ContractEntityInterface $contract);
    public function getContractDocuments(ContractEntityInterface $contract);
    public function downloadProofOfSignatureZip(ContractEntityInterface $contract): BinaryFileResponse;
    public function getVendorParty(ContractEntityInterface $contract): ContractPartyEntityInterface;
    public function sendNotificationContractNeedsVariablesValues(ContractEntityInterface $contract);
}
