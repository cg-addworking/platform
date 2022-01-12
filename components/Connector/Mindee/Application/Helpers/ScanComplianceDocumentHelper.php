<?php

namespace Components\Connector\Mindee\Application\Helpers;

use App\Jobs\Addworking\Common\File\SendToStorageJob;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Connector\Mindee\Application\Data\ExtraitKbisData;
use Components\Connector\Mindee\Application\Data\KbisSocieteData;
use Components\Connector\Mindee\Application\Data\RegularisationFiscaleMicroData;
use Components\Connector\Mindee\Application\Data\UrssafMicroData;
use Components\Connector\Mindee\Application\Data\UrssafSocieteData;
use Components\Connector\Mindee\Application\Extractors\ClassificationExtraitKbisOrD1Extractor;
use Components\Connector\Mindee\Application\Extractors\ExtraitKbisExtractor;
use Components\Connector\Mindee\Application\Extractors\RegularisationFiscaleMicroExtractor;
use Components\Connector\Mindee\Application\Extractors\UrssafMicroExtractor;
use Components\Connector\Mindee\Application\Extractors\UrssafSocieteExtractor;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Application\Validators\DocumentValidationResponse;
use Components\Infrastructure\FileDataExtractor\Application\Validators\ExtraitKbisValidator;
use Components\Infrastructure\FileDataExtractor\Application\Validators\RegulariteFiscaleMicroValidator;
use Components\Infrastructure\FileDataExtractor\Application\Validators\UrssafCertificateDocumentValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ScanComplianceDocumentHelper
{
    /**
     * @param Request $request
     * @param Enterprise $enterprise
     * @param DocumentType $document_type
     * @return ComplianceDocumentDataInterface|null
     */
    public function getDocumentData(
        Request $request,
        Enterprise $enterprise,
        DocumentType $document_type
    ): ?ComplianceDocumentDataInterface {
        $document_data = null;
        $data_extractor = null;
        switch ($document_type->name) {
            case DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_PAYMENT_SOCIAL_CONTRIBUTION:
                $data_extractor = in_array(
                    $enterprise->legalForm()->first()->name,
                    [LegalForm::EI, LegalForm::MICRO, LegalForm::SARLU]
                ) ?
                    new UrssafMicroExtractor() :
                    new UrssafSocieteExtractor();
                break;
            case DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_PERSONNAL_TAX_REGULARITY_OF_SARLU_OWNER:
                if ($enterprise->legalForm()->first()->name === LegalForm::SARLU) {
                    $data_extractor = new UrssafMicroExtractor();
                }
                break;
            case DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_ESTABLISHMENT:
                $classification = new ClassificationExtraitKbisOrD1Extractor();
                $data = $classification->getData(
                    base64_decode(json_decode($request->get('document_files')[0])->data)
                );
                if ($data->isExtraitKbis()) {
                    $data_extractor = new ExtraitKbisExtractor();
//                $data_extractor = new KbisSocieteExtractor();
                }
//                elseif ($data->isExtraitD1()) {}
                break;
            case DocumentType::DOCUMENT_TYPES_CERTIFICATE_OF_TAX_REGULARITY:
                if (in_array(
                    $enterprise->legalForm()->first()->name,
                    [LegalForm::EI, LegalForm::MICRO]
                )) {
                    $data_extractor = new RegularisationFiscaleMicroExtractor();
                }
                break;
        }

        if (!is_null($data_extractor)) {
            $file_content = base64_decode(json_decode($request->get('document_files')[0])->data);
            $document_data = $data_extractor->getData($file_content);
        }

        return $document_data;
    }

    /**
     * @param ComplianceDocumentDataInterface $document_data
     * @param DocumentType $document_type
     * @return bool
     */
    public function checkComplianceDocumentDate(
        ComplianceDocumentDataInterface $document_data,
        DocumentType                    $document_type
    ): bool {
        $document_valid_from  = $document_data->getDateValidFrom();
        if (!is_null($document_valid_from)) {
            $document_valid_until = clone $document_valid_from;
            $document_valid_until->addDays($document_type->validity_period);

            return $document_valid_from->isFuture() ||
                Carbon::now()->between($document_valid_from, $document_valid_until);
        }
        return true;
    }

    /**
     * @param ComplianceDocumentDataInterface $document_data
     * @return DocumentValidatorInterface|null
     */
    public function getDocumentComplianceValidator(
        ComplianceDocumentDataInterface $document_data
    ): ?DocumentValidatorInterface {
        if ($document_data instanceof UrssafSocieteData ||
            $document_data instanceof UrssafMicroData) {
            return App::make(UrssafCertificateDocumentValidator::class);
        } elseif ($document_data instanceof RegularisationFiscaleMicroData) {
            return App::make(RegulariteFiscaleMicroValidator::class);
        } elseif ($document_data instanceof ExtraitKbisData) {
            return App::make(ExtraitKbisValidator::class);
        }
        return null;
    }

    /**
     * @param Document $document
     * @param ComplianceDocumentDataInterface $document_data
     * @return bool
     */
    public function isIdentificationNumberValid(
        Document $document,
        ComplianceDocumentDataInterface $document_data
    ): bool {
        $is_valid = ($document_data instanceof UrssafSocieteData &&
                $document->enterprise->siren === $document_data->getSirenNumber())
            || ($document_data instanceof UrssafMicroData &&
                $document->enterprise->identification_number === $document_data->getNumeroSiret())
            || ($document_data instanceof KbisSocieteData &&
                $document->enterprise->siren === $document_data->getNumeroSiren())
            || ($document_data instanceof ExtraitKbisData &&
                $document->enterprise->siren === $document_data->getNumeroSiren())
            || ($document_data instanceof RegularisationFiscaleMicroData &&
                $document->enterprise->identification_number === $document_data->getNumeroSiret());
        $this->trackActionSiretIsValidOrNot($document, $is_valid);
        return $is_valid;
    }

    /**
     * Use the @ActionTrackingHelper to log the event
     */
    private function trackActionSiretIsValidOrNot(Document $document, bool $is_valid)
    {
        if ($is_valid) {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_SIREN_IS_VALID,
                $document,
                __(
                    'addworking.enterprise.document.create.scan_urssaf_certificate_siren_is_valid',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        } else {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_SIREN_IS_NOT_VALID,
                $document,
                __(
                    'addworking.enterprise.document.create.scan_urssaf_certificate_siren_is_not_valid',
                    ['time' => Carbon::now()->format('H:i')]
                )
            );
        }
    }

    /**
     * @param ComplianceDocumentDataInterface $document_data
     * @param DocumentValidatorInterface $validator
     * @param $key_code
     * @return DocumentValidationResponseInterface|null
     */
    public function getDocumentComplianceValidatorResponse(
        ComplianceDocumentDataInterface $document_data,
        DocumentValidatorInterface $validator,
        $key_code
    ): ?DocumentValidationResponseInterface {
        if (!is_null($key_code)) {
            if ($document_data instanceof UrssafSocieteData ||
                $document_data instanceof UrssafMicroData) {
                return $validator->checkProofOfAuthenticity($key_code);
            } elseif ($document_data instanceof RegularisationFiscaleMicroData) {
                return $validator->checkProofOfAuthenticity($key_code);
            } elseif ($document_data instanceof ExtraitKbisData) {
                return $validator->checkProofOfAuthenticity($key_code);
            }
        }
        return null;
    }


    /**
     * Saves the proof of authenticity from the response to the document
     * @param Document $document
     * @param DocumentValidationResponse $response
     * @return void
     */
    public function saveProofOfAuthenticity(Document $document, DocumentValidationResponse $response)
    {
        Log::info("ScanComplianceDocumentJob: Saving proof of Authenticity");
        $file = $response->getScreenshot();
        $content = $file->openFile('r')->fread($file->getSize());

        $file = new File([
            'path' => storage_path(uniqid().'.png'),
            'mime_type' => mime_content_type($file->getPathname()),
            'name' => $file->getFilename().'.png',
        ]);
        $file->md5 = md5($content);
        $file->size = strlen($content);
        $file = $file->saveAndGet();

        SendToStorageJob::dispatchNow($file->id, $content);

        $document->setProofAuthenticity($file);
        $document->save();
        ActionTrackingHelper::track(
            null,
            ActionEntityInterface::SCAN_URSSAF_CERTIFICATE_SAVE_PROOF_OF_AUTHENTICITY,
            $document,
            __(
                'addworking.enterprise.document.create.scan_urssaf_certificate_save_proof_of_authenticity',
                ['time' => Carbon::now()->format('H:i')]
            )
        );

        Log::info("ScanComplianceDocumentJob: Proof of authenticity saved");
    }
}
