<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Illuminate\Support\Facades\App;

class ContractStateRepository implements ContractStateRepositoryInterface
{
    private $contractVariableRepository;
    private $contractRepository;

    public function __construct()
    {
        $this->contractVariableRepository = App::make(ContractVariableRepository::class);
        $this->contractRepository = App::make(ContractRepository::class);
    }

    public function updateContractState(ContractEntityInterface $contract): ContractEntityInterface
    {
        $contract->setState($this->getState($contract));
        $contract = $this->contractRepository->save($contract);

        $contract_parent = $contract->getParent();
        if (isset($contract_parent)) {
            $contract_parent->setState($contract_parent->getState());
            $this->contractRepository->save($contract_parent);
        }

        return $contract;
    }

    public function getState(ContractEntityInterface $contract): string
    {
        switch (true) {
            case ($this->isCanceled($contract)):
                $state = ContractEntityInterface::STATE_CANCELED;
                break;
            case ($this->isArchived($contract)):
                $state = ContractEntityInterface::STATE_ARCHIVED;
                break;
            case ($this->isInactive($contract)):
                $state = ContractEntityInterface::STATE_INACTIVE;
                break;
            case ($this->isDue($contract)):
                $state = ContractEntityInterface::STATE_DUE;
                break;
            case ($this->isActive($contract)):
                $state = ContractEntityInterface::STATE_ACTIVE;
                break;
            case ($this->isSigned($contract)):
                $state = ContractEntityInterface::STATE_SIGNED;
                break;
            case ($this->isDeclined($contract)):
                $state = ContractEntityInterface::STATE_DECLINED;
                break;
            case ($this->toSign($contract)):
                $state = ContractEntityInterface::STATE_TO_SIGN;
                break;
            case ($this->toValidate($contract)):
                $state = ContractEntityInterface::STATE_TO_VALIDATE;
                break;
            case ($this->generated($contract)):
                $state = ContractEntityInterface::STATE_GENERATED;
                break;
            case ($this->isReadyToGenerate($contract)):
                $state = ContractEntityInterface::STATE_IS_READY_TO_GENERATE;
                break;
            case ($this->isInPreparation($contract)):
                $state = ContractEntityInterface::STATE_IN_PREPARATION;
                break;
            case ($this->isMissingDocuments($contract)):
                $state = ContractEntityInterface::STATE_MISSING_DOCUMENTS;
                break;
            case ($this->isDraft($contract)):
                $state = ContractEntityInterface::STATE_DRAFT;
                break;
            default:
                $state = ContractEntityInterface::STATE_UNKNOWN;
        }
        
        return $state;
    }

    public function isCanceled(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract) && ! is_null($contract->getCanceledAt());
    }

    public function isInactive(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract) && ! is_null($contract->getInactiveAt());
    }

    public function isDue(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfContractIsSigned($contract)
            && $this->contractRepository->isDateDue($contract);
    }

    public function isActive(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && count($this->contractRepository->getContractParts($contract)) >= 1
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfContractIsSigned($contract)
            && ($this->contractRepository->isDateActive($contract)
                || $this->contractRepository->hasActiveAmendment($contract)
            );
    }

    public function isSigned(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && count($this->contractRepository->getContractParts($contract)) >= 1
            && $this->contractRepository->checkIfContractIsSigned($contract);
    }

    public function isDeclined(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && count($this->contractRepository->getContractParts($contract)) >= 1
            && $this->contractRepository->checkIfContractIsDeclined($contract);
    }

    public function toSign(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract)
            && count($this->contractRepository->getContractParts($contract)) >= 1
            && (
                ($this->contractRepository->hasContractModel($contract)
                && $this->contractRepository->checkIfHasPartsWithContractModel($contract)
                && $this->contractRepository->hasYousignProcedureId($contract)) ||
                !$this->contractRepository->hasContractModel($contract)
            ) && !is_null($contract->getSentToSignatureAt())
            && $this->contractRepository->getPendingValidatorParties($contract)->count() === 0;
    }

    public function toValidate(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract)
            && ($this->contractRepository->checkIfHasPartsWithContractModel($contract)
                || ! $this->contractRepository->hasContractModel($contract)
            ) && count($this->contractRepository->getContractParts($contract)) >= 1
            && $this->contractRepository->hasYousignProcedureId($contract)
            && !is_null($contract->getSentToSignatureAt())
            && $this->contractRepository->getPendingValidatorParties($contract)->count() >= 1;
    }

    public function generated(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract)
            && ($this->contractRepository->checkIfHasPartsWithContractModel($contract)
                || ! $this->contractRepository->hasContractModel($contract)
            ) && count($this->contractRepository->getContractParts($contract)) >= 1
            && !$this->contractRepository->hasYousignProcedureId($contract)
            && is_null($contract->getSentToSignatureAt());
    }

    public function isReadyToGenerate(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && $this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract)
            &&  (! $this->contractRepository->checkIfHasPartsWithContractModel($contract)
                || ! $this->contractRepository->hasContractModel($contract)
            )
            && !$this->contractRepository->hasYousignProcedureId($contract);
    }

    public function isInPreparation(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && !$this->contractRepository->checkIfContractIsSigned($contract)
            &&  ! $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract);
    }

    public function isMissingDocuments(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) >= 2
            && !$this->contractRepository->checkIfContractIsSigned($contract)
            && $this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($contract)
            && !$this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract);
    }

    public function isDraft(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract)
            && count($this->contractRepository->getSignatoryParties($contract)) < 2;
    }

    public function isArchived(ContractEntityInterface $contract): bool
    {
        return ! is_null($contract) && ! is_null($contract->getArchivedAt());
    }
}
