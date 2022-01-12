<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Entities;

use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use DateTime;

interface DocumentTypeModelVariableEntityInterface
{
    // text
    const INPUT_TYPE_TEXT      = 'text';
    const INPUT_TYPE_DATE      = 'date';

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

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setDocumentTypeModel(DocumentTypeModel $document_type_model): void;
    public function setDisplayName(string $display_name): void;
    public function setName(string $display_name): void;
    public function setDescription(?string $description): void;
    public function setShortId(): void;
    public function setDefaultValue(?string $default_value): void;
    public function setRequired(bool $required): void;
    public function setInputType(string $input_type): void;
    public function setOptions(?array $options): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getDocumentTypeModel(): ?DocumentTypeModel;
    public function getName(): ?string;
    public function getDisplayName(): ?string;
    public function getId(): ?string;
    public function getInputType();
    public function getDefaultValue();
    public function getOptions();
    public function getDescription();
    public function getUpdatedAt();
}
