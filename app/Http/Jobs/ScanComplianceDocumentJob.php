<?php

namespace App\Http\Jobs;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Connector\Mindee\Application\Helpers\ScanComplianceDocumentHelper;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Receives a  @Document
 * reads it to get its informations
 * checks if its data matches as the Enterprise's data
 * if not, the document is not valid, create an ActionTracking
 * might check on the document authentifier website if the document is valid and takes a screenshot
 * might save the screenshot as the proof of authenticity
 * if the document is valid we pre-check it
 */
class ScanComplianceDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Document $document
     */
    protected Document $document;

    /**
     * @var ComplianceDocumentDataInterface $document_data
     */
    protected ComplianceDocumentDataInterface $document_data;

    /**
     * @var ?DocumentValidatorInterface $validator
     */
    protected ?DocumentValidatorInterface $validator;

    /**
     * @var ScanComplianceDocumentHelper $scan_compliance_document_helper
     */
    protected ScanComplianceDocumentHelper $scan_compliance_document_helper;

    public const ALLOWED_DOCUMENT_TYPE = [
        DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_PAYMENT_SOCIAL_CONTRIBUTION,
        DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_PERSONNAL_TAX_REGULARITY_OF_SARLU_OWNER,
        DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_ESTABLISHMENT,
        DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_TAX_REGULARITY,
    ];

    public function __construct(
        Document $document,
        ComplianceDocumentDataInterface $document_data,
        ScanComplianceDocumentHelper $scan_compliance_document_helper
    ) {
        $this->document                        = $document;
        $this->document_data                   = $document_data;
        $this->scan_compliance_document_helper = $scan_compliance_document_helper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Start ScanComplianceDocumentJob");
        if (!in_array($this->document->documentType->name, self::ALLOWED_DOCUMENT_TYPE)) {
            Log::info("Exit ScanComplianceDocumentJob because of wrong document type.");
            return;
        }

        $this->validator = $this->scan_compliance_document_helper->getDocumentComplianceValidator($this->document_data);

        $validated = $this->validateDocument();

        if ($this->validator) {
            $validated = $this->validator->specificValidation(
                $this->document_data,
                $this->document,
                $validated
            );
        }

        $validated = $this->validateDate($validated);

        $this->updateDocumentFromComplianceDocumentData($validated);


        $this->trackActionsSuccessOrFail($validated);
    }

    /**
     * Checks if the siren of the urssaf file is the same as the Document's Enterprise's siren
     * if not, the document is not valid, create an ActionTracking
     * use the verification key to checks on the urssaf website if the document is valid
     *
     * @param $pdfPath
     * @return bool
     */
    private function validateDocument(): bool
    {
        $validated = true;
        try {
            if (!$this->scan_compliance_document_helper->isIdentificationNumberValid(
                $this->document,
                $this->document_data
            )) {
                Log::info("ScanComplianceDocumentJob: Siret or Siren is not valid");
                $validated = false;
            }

            if (!is_null($this->document_data->getSecurityCode()) && $this->document_data->getSecurityCode()) {
                Log::info("ScanComplianceDocumentJob: Validating document with key code : "
                    . $this->document_data->getSecurityCode());
                $validator_response = $this->scan_compliance_document_helper->getDocumentComplianceValidatorResponse(
                    $this->document_data,
                    $this->validator,
                    $this->document_data->getSecurityCode()
                );
                if ($validator_response) {
                    $validated = $validated && $validator_response->isValid(false);
                    if ($validator_response->isValid()) {
                        $this->scan_compliance_document_helper->saveProofOfAuthenticity(
                            $this->document,
                            $validator_response
                        );
                    } else {
                        ActionTrackingHelper::track(
                            null,
                            ActionEntityInterface::SCAN_COMPLIANCE_DOCUMENT_COULDNT_VALIDATE_SECURITY_CODE,
                            $this->document,
                            __(
                                'addworking.enterprise.document.create.'.
                                'scan_compliance_document_couldnt_validate_security_code',
                                ['time' => Carbon::now()->format('H:i')]
                            )
                        );
                    }
                } else {
                    Log::info("ScanComplianceDocumentJob: Could not find validator or validate document.");
                }
            } else {
                ActionTrackingHelper::track(
                    null,
                    ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_DOCUMENT_VALIDATION,
                    $this->document,
                    __(
                        'addworking.enterprise.document.create.scan_compliance_document_couldnt_read_security_code',
                        ['time' => Carbon::now()->format('H:i')]
                    )
                );

                return false;
            }
        } catch (\Exception $e) {
            Log::error($e);
            Log::info("ScanComplianceDocumentJob: Error : " . $e->getMessage());
            $validated = false;

            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_COMPLIANCE_DOCUMENT_COULDNT_SAVE_PROOF_OF_AUTHENTICITY,
                $this->document,
                __(
                    'addworking.enterprise.document.create.'
                    .'scan_compliance_document_couldnt_save_proof_of_authenticity',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        }

        return $validated;
    }

    /**
     * Use the @ActionTrackingHelper to log the event
     *
     * @param bool $validated
     */
    private function trackActionsSuccessOrFail(bool $validated)
    {
        if ($validated) {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_DOCUMENT_VALIDATION,
                $this->document,
                __(
                    'addworking.enterprise.document.create.scan_urssaf_certificate_document_validation',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        } else {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_DOCUMENT_REJECTION,
                $this->document,
                __(
                    'addworking.enterprise.document.create.scan_urssaf_certificate_document_rejection',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        }
    }

    /**
     * Update document with the urssaf document data and the document type validity period
     */
    private function updateDocumentFromComplianceDocumentData(bool $validated)
    {
        $valid_from = $this->document_data->getDateValidFrom();
        $valid_until = null;
        if (!is_null($valid_from)) {
            $valid_until = clone $valid_from;
            $valid_until->addDays($this->document->documentType->validity_period);
            $is_date_valid = $valid_from->isFuture() || Carbon::now()->between($valid_from, $valid_until);
            $validated = $validated && $is_date_valid;
            if ($is_date_valid) {
                $this->document->update(
                    [
                        'is_pre_check' => $validated &&
                            $this->document->documentType->name
                            !== DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_ESTABLISHMENT,
                        'valid_from' => $valid_from,
                        'valid_until' => $valid_until,
                    ]
                );
            }
        }
        return $validated;
    }

    private function validateDate($validated)
    {
        $valid_until = null;
        $is_date_valid = false;
        $valid_from = $this->document_data->getDateValidFrom();
        if (!is_null($valid_from)) {
            $valid_until = clone $valid_from;
            $valid_until->addDays($this->document->documentType->validity_period);
            $is_date_valid = $valid_from->isFuture() || Carbon::now()->between($valid_from, $valid_until);
            if (!$is_date_valid) {
                ActionTrackingHelper::track(
                    null,
                    ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_NOT_VALID,
                    $this->document,
                    __(
                        'addworking.enterprise.document.create.scan_urssaf_certificate_extracted_date_is_not_valid',
                        ['time' => Carbon::now()->format('H:i')]
                    )
                );
            } else {
                ActionTrackingHelper::track(
                    null,
                    ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_EXTRACTED_DATE_IS_VALID,
                    $this->document,
                    __(
                        'addworking.enterprise.document.create.scan_urssaf_certificate_extracted_date_is_valid',
                        ['time' => Carbon::now()->format('H:i')]
                    )
                );
            }
        } else {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_EXTRACTORS_COULD_NOT_READ_DATE,
                $this->document,
                __(
                    'addworking.enterprise.document.create.scan_urssaf_certificate_extractors_could_not_read_date',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        }

        return $validated && $is_date_valid;
    }
}
