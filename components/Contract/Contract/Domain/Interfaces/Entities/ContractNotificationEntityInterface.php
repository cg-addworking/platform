<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

interface ContractNotificationEntityInterface
{
    const REQUEST_SIGNATURE                  = "request_signature";
    const REQUEST_VALIDATION_ON_YOUSIGN      = "request_validation_on_yousign";
    const REQUEST_SEND_CONTRACT_TO_SIGNATURE = "request_send_contract_to_signature";
    const REQUEST_DOCUMENTS                  = "request_documents";
    const REQUEST_CONTRACT_VARIABLE_VALUE    = "request_contract_variable_value";
    const SIGNED_CONTRACT                    = "signed_contract";
    const REFUSED_CONTRACT                   = "refused_contract";
    const CONTRACT_NEEDS_VARIABLES_VALUES    = "contrcat_needs_variables_values";

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract): void;
    public function setSentTo($user): void;

    public function setNotificationName(string $notification_name): void;
    public function setSentDate($sent_date): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getNotificationName(): string;
    public function getSentDate();
}
