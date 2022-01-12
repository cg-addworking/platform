<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use App\Models\Addworking\Enterprise\Document;
use Components\Connector\Mindee\Application\Data\ExtraitKbisData;
use Components\Connector\Mindee\Application\Data\RegularisationFiscaleMicroData;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\WrongDocumentDataPassedToValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Spatie\Browsershot\Browsershot;

class RegulariteFiscaleMicroValidator implements DocumentValidatorInterface
{
    public function checkProofOfAuthenticity(string $key_code): RegulariteFiscaleMicroResponse
    {
        if (! $key_code) {
            return new RegulariteFiscaleMicroResponse(false);
        }

        $browsershot = Browsershot::url('https://www.secu-independants.fr/contact/attestations/');
        if (env('APP_ENV') != 'local') {
            $browsershot->setChromePath('/app/.apt/usr/bin/google-chrome');
        }
        $browsershot->waitUntilNetworkIdle(false)
            ->click('#footer_tc_privacy_button_3')
            ->type('#attest_id', $key_code)
            ->click('.big-btn')
            ->delay(1000);

        $verification_key_code = $browsershot->evaluate(
            "$('.alternatif > thead:nth-child(1) > tr:nth-child(1) > th:nth-child(1)').text().trim()"
        );

        if ($verification_key_code !== $key_code) {
            return new RegulariteFiscaleMicroResponse(false);
        }

        return new RegulariteFiscaleMicroResponse(true, $this->getData($browsershot, $verification_key_code));
    }

    private function getData($browsershot, $verification_key_code)
    {
        $issuing_body = $browsershot->evaluate(
            "$('.alternatif > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(2)').text()"
        );
        $company_name = $browsershot->evaluate(
            "$('.alternatif > tbody:nth-child(2) > tr:nth-child(2) > td:nth-child(2)').text()"
        );
        $delivered_at = $browsershot->evaluate(
            "$('.alternatif > tbody:nth-child(2) > tr:nth-child(3) > td:nth-child(2)').text()"
        );

        $screenshot = tempnam(sys_get_temp_dir(), "regularite_fiscale_".uniqid());
        file_put_contents($screenshot, $browsershot->screenshot());
        rename($screenshot, $screenshot .= '.png');


        return [
            'screenshot' => $screenshot,
            'data' => [
                'verification_key_code' => $verification_key_code,
                'issuing_body'          => $issuing_body,
                'company_name'          => $company_name,
                'delivered_at'          => $delivered_at,
            ],
        ];
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
        if (!$data instanceof RegularisationFiscaleMicroData) {
            throw new WrongDocumentDataPassedToValidator();
        }
        return $prevalidation;
    }
}
