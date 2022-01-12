<?php

namespace Components\Contract\Model\Domain\Interfaces\Entities;

interface ContractModelVariableEntityInterface
{
    // text
    const INPUT_TYPE_TEXT      = 'text';
    const INPUT_TYPE_LONG_TEXT = 'long_text';
    const INPUT_TYPE_DATE      = 'date';
    const INPUT_TYPE_OPTIONS   = 'options';

    // enterprise
    const INPUT_TYPE_ENTERPRISE_NAME = 'enterprise_name';
    const INPUT_TYPE_ENTERPRISE_ADDRESS = 'enterprise_address';
    const INPUT_TYPE_ENTERPRISE_TOWN = 'enterprise_town';
    const INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER = 'enterprise_identification_number';
    const INPUT_TYPE_ENTERPRISE_LEGAL_FORM = 'enterprise_legal_form';
    const INPUT_TYPE_ENTERPRISE_SIREN_NUMBER = 'enterprise_siren_number';
    const INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN = 'enterprise_registration_town';
    const INPUT_TYPE_ENTERPRISE_REGISTRATION_DATE = 'enterprise_registration_date';
    const INPUT_TYPE_ENTERPRISE_EMPLOYEES_NUMBER = 'enterprise_employees_number';

    // signatory
    const INPUT_TYPE_SIGNATORY_NAME = 'signatory_name';
    const INPUT_TYPE_SIGNATORY_MAIL = 'signatory_mail';
    const INPUT_TYPE_SIGNATORY_FUNCTION = 'signatory_function';

    // contract
    const INPUT_TYPE_CONTRACT_ENTERPRISE_OWNER = 'contract_enterprise_owner';
    const INPUT_TYPE_CONTRACT_VALID_FROM = 'contract_valid_from';
    const INPUT_TYPE_CONTRACT_VALID_UNTIL = 'contract_valid_until';
    const INPUT_TYPE_CONTRACT_EXTERNAL_IDENTIFIER = 'contract_external_identifier';

    // mission
    const INPUT_TYPE_STARTED_AT                 = 'mission_started_at';
    const INPUT_TYPE_ENDED_AT                   = 'mission_ended_at';
    const INPUT_TYPE_MISSION_AMOUNT = "mission_amount";

    // work_field
    const INPUT_TYPE_WORK_FIELD_DESCRIPTION     = 'work_field_description';
    const INPUT_TYPE_WORK_FIELD_PROJECT_OWNER   = 'work_field_project_owner';
    const INPUT_TYPE_WORK_FIELD_PROJECT_MANAGER = 'work_field_project_manager';
    const INPUT_TYPE_WORK_FIELD_ADDRESS         = 'work_field_address';
    const INPUT_TYPE_WORK_FIELD_DISPLAY_NAME    = 'work_field_display_name';
    const INPUT_TYPE_WORK_FIELD_EXTERNAL_ID     = 'work_field_external_id';
    const INPUT_TYPE_WORK_FIELD_STARTED_AT      = 'work_field_started_at';
    const INPUT_TYPE_WORK_FIELD_ENDED_AT        = 'work_field_ended_at';
    const INPUT_TYPE_WORK_FIELD_SPS_COORDINATOR = 'work_field_sps_coordinator';

    const INPUTS_WORKFIELD = [
        self::INPUT_TYPE_WORK_FIELD_DESCRIPTION,
        self::INPUT_TYPE_WORK_FIELD_PROJECT_OWNER,
        self::INPUT_TYPE_WORK_FIELD_PROJECT_MANAGER,
        self::INPUT_TYPE_WORK_FIELD_ADDRESS,
        self::INPUT_TYPE_WORK_FIELD_DISPLAY_NAME,
        self::INPUT_TYPE_WORK_FIELD_EXTERNAL_ID,
        self::INPUT_TYPE_WORK_FIELD_STARTED_AT,
        self::INPUT_TYPE_WORK_FIELD_ENDED_AT,
        self::INPUT_TYPE_WORK_FIELD_SPS_COORDINATOR,
    ];

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): ?string;
    public function getName(): string;
    public function getDisplayName(): ?string;
    public function getContractModelParty(): ?ContractModelPartyEntityInterface;
    public function getContractModelPart();
    public function getDefaultValue(): ?string;
    public function getDescription(): ?string;
    public function getRequired(): bool;
    public function getIsExportable(): bool;
    public function getInputType(): string;
    public function getOrder(): int;
    public function getOptions(): ?array;
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContractModel(ContractModelEntityInterface $contract_model);
    public function setContractModelPart(ContractModelPartEntityInterface $contract_model_part);
    public function removeContractModelPart(ContractModelPartEntityInterface $contract_model_part);
    public function setContractModelParty(ContractModelPartyEntityInterface $contract_model_party);
    public function setName(string $name);
    public function setNumber();
    public function setDisplayName(?string $display_name);
    public function setDescription(?string $description);
    public function setDefaultValue(?string $default_value);
    public function setRequired(bool $required);
    public function setIsExportable(bool $is_exportable);
    public function setInputType(string $input_type);
    public function setOrder(int $order): void;
    public function setOptions(array $options);
}
