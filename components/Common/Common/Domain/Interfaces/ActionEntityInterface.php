<?php

namespace Components\Common\Common\Domain\Interfaces;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Models\ActionType;
use Illuminate\Database\Eloquent\Model;

interface ActionEntityInterface extends EntityInterface
{
    const CREATE = "create";
    const UPDATE = "update";
    const SHOW   = "show";
    const DELETE = "delete";

    //Invoice
    const VALIDATE_INBOUND_INVOICE     = "validate_inbound_invoice";
    const REPLACE_FILE_INBOUND_INVOICE = "replace_file_inbound_invoice";
    const VALIDATE_DOCUMENT_TYPE = "validate_document_type";
    const REJECT_DOCUMENT_TYPE = "reject_document_type";
    const REJECT_DOCUMENT_TYPE_NOTIFICATION = "reject_document_type_notification";
    const EXPIRE_DOCUMENT_TYPE_NOTIFICATION = "expire_document_type_notification";
    const EXPIRED_DOCUMENT_TYPE_NOTIFICATION = "expired_document_type_notification";
    const PAID_INBOUND_INVOICE = "paid_inbound_invoice";
    const OUTDATED_DOCUMENT_TYPE_NOTIFICATION = "outdated_document_type_notification";

    //Contract
    const CREATE_CONTRACT                       = 'create_contract';
    const CREATE_AMENDMENT                      = 'create_amendment';
    const REQUEST_SEND_CONTRACT_TO_SIGNATURE    = 'request_send_contract_to_signature';
    const SEND_CONTRACT_TO_SIGNATURE            = 'send_contract_to_signature';
    const SEND_CONTRACT_TO_VALIDATION           = 'send_contract_to_validation';
    const PARTY_VALIDATES_CONTRACT              = 'party_validates_contract';
    const PARTY_SIGNS_CONTRACT                  = 'party_signs_contract';
    const PARTY_REFUSES_TO_SIGN_CONTRACT        = 'party_refuses_to_sign_contract';
    const CONTRACT_PRE_EXPIRE_NOTIFICATION      = 'contract_pre_expire_notification';
    const CONTRACT_IS_ACTIVE                    = 'contract_is_active';
    const CONTRACT_EXPIRES                      = 'contract_expires';
    const CONTRACT_CALLBACK                     = 'contract_callback';
    const CONTRACT_ARCHIVED                     = 'contract_archived';
    const CONTRACT_UNARCHIVED                   = 'contract_unarchived';
    const CONTRACT_VARIABLE_VALUE_WAS_REQUESTED = 'contract_variable_value_was_requested';
    const CONTRACT_REQUEST_DOCUMENT             = 'contract_contract_request_document';

    // OCR and document scans
    const SCAN_URSSAF_CERTIFICATE_DOCUMENT_VALIDATION         = 'scan_urssaf_certificate_document_validation';
    const SCAN_URSSAF_CERTIFICATE_DOCUMENT_REJECTION          = 'scan_urssaf_certificate_document_rejection';
    const SCAN_URSSAF_CERTIFICATE_SIREN_IS_NOT_VALID          = 'scan_urssaf_certificate_siren_is_not_valid';
    const SCAN_URSSAF_CERTIFICATE_SIREN_IS_VALID              = 'scan_urssaf_certificate_siren_is_valid';
    const SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_NOT_VALID = 'scan_urssaf_certificate_extracted_date_is_not_valid';
    const SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_VALID     = 'scan_urssaf_certificate_extracted_date_is_valid';
    const SCAN_URSSAF_CERTIFICATE_EXTRACTORS_COULD_NOT_READ_DATE =
                                                'scan_urssaf_certificate_extractors_could_not_read_date';
    const SCAN_URSSAF_CERTIFICATE_SAVE_PROOF_OF_AUTHENTICITY  =
                                                'scan_urssaf_certificate_save_proof_of_authenticity';
    const SCAN_COMPLIANCE_DOCUMENT_COULDNT_SAVE_PROOF_OF_AUTHENTICITY =
                                                'scan_compliance_document_couldnt_save_proof_of_authenticity';
    const SCAN_COMPLIANCE_DOCUMENT_COULDNT_READ_SECURITY_CODE     =
                                                'scan_compliance_document_couldnt_read_security_code';
    const SCAN_COMPLIANCE_DOCUMENT_COULDNT_VALIDATE_SECURITY_CODE =
                                                'scan_compliance_document_couldnt_validate_security_code';
    const SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_TOWN = 'scan_extract_kbis_document_couldnt_validate_town';
    const SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_TOWN = 'scan_extract_kbis_document_has_validated_town';
    const SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_ADDRESS = 'scan_extract_kbis_document_couldnt_validate_address';
    const SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_ADDRESS = 'scan_extract_kbis_document_has_validated_address';
    const SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_COMPANY_NAME =
                                                         'scan_extract_kbis_document_couldnt_validate_company_name';
    const SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_COMPANY_NAME =
                                                        'scan_extract_kbis_document_has_validated_company_name';
    const SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_LEGAL_FORM =
                                                        'scan_extract_kbis_document_couldnt_validate_legal_form';
    const SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_LEGAL_FORM = 'scan_extract_kbis_document_has_validated_legal_form';
    const SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_END_OF_EXTRACT =
                                                        'scan_extract_kbis_document_couldnt_validate_end_of_extract';
    const SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_END_OF_EXTRACT =
                                                        'scan_extract_kbis_document_has_validated_end_of_extract';
    const SCAN_COMPLIANCE_DOCUMENT_ERROR_OCCURRED     = 'scan_compliance_document_error_occurred';

    const AVAILABLE_ACTION_NAMES = [
        self::CREATE,
        self::UPDATE,
        self::SHOW,
        self::DELETE,
        self::VALIDATE_INBOUND_INVOICE,
        self::REPLACE_FILE_INBOUND_INVOICE,
        self::VALIDATE_DOCUMENT_TYPE,
        self::REJECT_DOCUMENT_TYPE,
        self::REJECT_DOCUMENT_TYPE_NOTIFICATION,
        self::EXPIRE_DOCUMENT_TYPE_NOTIFICATION,
        self::EXPIRED_DOCUMENT_TYPE_NOTIFICATION,
        self::OUTDATED_DOCUMENT_TYPE_NOTIFICATION,
        self::CREATE_CONTRACT,
        self::CREATE_AMENDMENT,
        self::REQUEST_SEND_CONTRACT_TO_SIGNATURE,
        self::SEND_CONTRACT_TO_SIGNATURE,
        self::SEND_CONTRACT_TO_VALIDATION,
        self::PARTY_VALIDATES_CONTRACT,
        self::PARTY_SIGNS_CONTRACT,
        self::PARTY_REFUSES_TO_SIGN_CONTRACT,
        self::CONTRACT_PRE_EXPIRE_NOTIFICATION,
        self::CONTRACT_IS_ACTIVE,
        self::CONTRACT_EXPIRES,
        self::PAID_INBOUND_INVOICE,
        self::CONTRACT_CALLBACK,
        self::CONTRACT_ARCHIVED,
        self::CONTRACT_UNARCHIVED,
        self::CONTRACT_VARIABLE_VALUE_WAS_REQUESTED,
        self::CONTRACT_REQUEST_DOCUMENT,
        self::SCAN_URSSAF_CERTIFICATE_DOCUMENT_VALIDATION,
        self::SCAN_URSSAF_CERTIFICATE_DOCUMENT_REJECTION,
        self::SCAN_URSSAF_CERTIFICATE_SIREN_IS_NOT_VALID,
        self::SCAN_URSSAF_CERTIFICATE_SIREN_IS_VALID,
        self::SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_VALID,
        self::SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_NOT_VALID,
        self::SCAN_URSSAF_CERTIFICATE_SAVE_PROOF_OF_AUTHENTICITY,
        self::SCAN_COMPLIANCE_DOCUMENT_COULDNT_SAVE_PROOF_OF_AUTHENTICITY,
        self::SCAN_URSSAF_CERTIFICATE_EXTRACTORS_COULD_NOT_READ_DATE,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_TOWN,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_TOWN,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_ADDRESS,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_ADDRESS,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_COMPANY_NAME,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_COMPANY_NAME,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_LEGAL_FORM,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_LEGAL_FORM,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_END_OF_EXTRACT,
        self::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_END_OF_EXTRACT,
        self::SCAN_COMPLIANCE_DOCUMENT_ERROR_OCCURRED,
        self::SCAN_COMPLIANCE_DOCUMENT_COULDNT_VALIDATE_SECURITY_CODE,
    ];

    public function setUser(?User $user);
    public function setMessage(string $message): void;
    public function setModel(Model $model): void;
    public function setName(string $name): void;
    public function setDisplayName(string $displayName): void;

    public function getUser(): ?User;
    public function getMessage(): string;
    public function getCreatedAt();
    public function getName(): string;
    public function getDisplayName(): string;
    public function getId(): string;
}
