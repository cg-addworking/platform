<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Connector\Mindee\Application\Data\ExtraitKbisData;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\WrongDocumentDataPassedToValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class ExtraitKbisValidator implements DocumentValidatorInterface
{
    const LEGAL_FORMS = [
        "sas" => "societe par actions simplifiee",
        "sasu" => "SASU",
        "sa" => "SA",
        "sarl" => "SARL",
        "sarlu" => "SARLU",
        "eurl" => "EURL",
        "eirl" => "EIRL",
        "ei" => "EI (Entreprise Individuelle)",
        "micro" => "Micro Entrepreneur",
        "EI" => "EI",
        "micro entrepreneur" => "MICRO",
    ];

    const ERROR_NO_DOCUMENT_FOUND = 'Aucun document trouvé pour ce code de vérification';
    const ERROR_CODE_ALREADY_USED =
        'Ce code de vérification a déjà été utilisé, vous ne pouvez plus consulter le document.';

    public function checkProofOfAuthenticity(string $key_code): DocumentValidationResponseInterface
    {
        if (! $key_code) {
            return new ExtraitKbisValidationResponse(false);
        }

        try {
            $browsershot = Browsershot::url('https://www.infogreffe.fr/controle/verif?codeVerif='.$key_code);
            if (env('APP_ENV') != 'local') {
                $browsershot->setChromePath('/app/.apt/usr/bin/google-chrome');
            }
            $browsershot->waitUntilNetworkIdle(true)
                ->click('#refusercookies');

            $verification_key_code = $browsershot->evaluate(
                "document.querySelector('p.spacer:nth-child(3) > span:nth-child(2)').innerHTML"
            );

            $error = $browsershot->evaluate(
                "document.querySelector('p.error') ? document.querySelector('p.error').innerHTML.trim() : ''"
            );

            if ($verification_key_code !== $key_code) {
                return new ExtraitKbisValidationResponse(false);
            }

            $screenshot = tempnam(sys_get_temp_dir(), "kbis_".uniqid());
            file_put_contents($screenshot, $browsershot->fullPage()->screenshot());
            rename($screenshot, $screenshot .= '.png');

            return new ExtraitKbisValidationResponse($error !== self::ERROR_NO_DOCUMENT_FOUND, [
                'screenshot' => $screenshot,
                'data' => [
                    'verification_key_code' => $verification_key_code,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return new ExtraitKbisValidationResponse(false);
        }
    }

    /**
     * @param ExtraitKbisData $data
     * @param Document $document
     * @param bool $prevalidation
     * @return bool
     * @throws WrongDocumentDataPassedToValidator
     */
    public function specificValidation(
        ComplianceDocumentDataInterface $data,
        Document $document,
        bool $prevalidation
    ): bool {
        if (!$data instanceof ExtraitKbisData) {
            throw new WrongDocumentDataPassedToValidator();
        }

        /* @var Enterprise $enterprise */
        $enterprise = $document->enterprise;

        if (trim(strtoupper($enterprise->registration_town)) !== trim(strtoupper($data->getRcsVille()))) {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_TOWN
            );
            $prevalidation = false;
        } else {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_TOWN
            );
        }

        $has_correct_address = false;
        foreach ($enterprise->addresses as $address) {
            /* @var Address $address */
            if (strtoupper(str_replace(',', '', $address->oneLine())) ===
                strtoupper($data->getAdresseSiege())
                || str_contains(
                    strtoupper(str_replace(',', '', $address->oneLine())),
                    strtoupper($data->getAdresseSiege())
                )) {
                $has_correct_address = true;
                break;
            }
        }
        if (!$has_correct_address) {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_ADDRESS
            );
            $prevalidation = false;
        } else {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_ADDRESS
            );
        }

        if (is_null($data->getDenominationSociale()) || $data->getDenominationSociale() === ''
            || !str_contains(strtoupper($enterprise->name), strtoupper($data->getDenominationSociale()))) {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_COMPANY_NAME
            );
            $prevalidation = false;
        } else {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_COMPANY_NAME
            );
        }

        if (is_null($data->getFinExtrait()) || $data->getFinExtrait() === '') {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_END_OF_EXTRACT
            );
            $prevalidation = false;
        } else {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_END_OF_EXTRACT
            );
        }

        if (is_null($data->getFormeJuridique()) || $data->getFormeJuridique() === ''
            || (!is_null($data->getFormeJuridique()) &&
            self::LEGAL_FORMS[strtolower(trim($enterprise->legalForm->display_name))]
            !== trim(strtolower($data->getFormeJuridique())))
        ) {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_COULDNT_VALIDATE_LEGAL_FORM
            );
            $prevalidation = false;
        } else {
            $this->logAction(
                $document,
                ActionEntityInterface::SCAN_EXTRACT_KBIS_DOCUMENT_HAS_VALIDATED_LEGAL_FORM
            );
        }

        return $prevalidation;
    }

    private function logAction(Document $document, string $action_name)
    {
        ActionTrackingHelper::track(
            null,
            $action_name,
            $document,
            __(
                'addworking.enterprise.document.create.'.$action_name,
                ['time' => Carbon::now()->format('H:i')]
            )
        );
    }
}
