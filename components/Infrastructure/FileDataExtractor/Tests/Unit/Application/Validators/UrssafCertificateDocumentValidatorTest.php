<?php

namespace Components\Infrastructure\FileDataExtractor\Tests\Unit\Application\Validators;

use Components\Infrastructure\FileDataExtractor\Application\Validators\UrssafCertificateDocumentValidator;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class UrssafCertificateDocumentValidatorTest extends TestCase
{
    use CreatesApplication;

    /**
     * @dataProvider checkDataProvider
     */
    public function testCheck(string $path, array $data)
    {
        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . config('ocr.google_application_credentials')
        );

        $validator = $this->app->make(UrssafCertificateDocumentValidator::class);
        $response = $validator->checkProofOfAuthenticity(new \SplFileInfo($path));

        $this->assertTrue(
            $response->getScreenshot()->isReadable(),
        );

        $this->assertEquals(
            $data['verification_key'],
            $response->getVerificationKey(),
        );

        $this->assertEquals(
            $data['nature'],
            $response->getNature(),
        );

        $this->assertEquals(
            $data['emitter'],
            $response->getEmitter(),
        );

        $this->assertEquals(
            $data['certificationDate'],
            $response->getCertificationDate(),
        );

        $this->assertEquals(
            $data['companyName'],
            $response->getCompanyName(),
        );

        $this->assertEquals(
            $data['companyEmployeesCount'],
            $response->getCompanyEmployeesCount(),
        );

        $this->assertEquals(
            $data['companySalaryWeight'],
            $response->getCompanySalaryWeight(),
        );

        $this->assertEquals(
            $data['period'],
            $response->getPeriod(),
        );

        $this->assertEquals(
            $data['siret'],
            $response->getSiret(),
        );

        $this->assertEquals(
            $data['address'],
            $response->getAddress(),
        );
    }

    public function checkDataProvider()
    {
        return [
            'Attestation URSSAF 2 - text pdf' => [
                'path' => __DIR__ . '/data/urssaf-2.pdf',
                'data' => [
                    'verification_key' => "ZE64MH8DRFP3REW",
                    'nature' => "Attestation de vigilance (AVG)",
                    'emitter' => "Vénissieux",
                    'certificationDate' => new \DateTime("2020-10-29"),
                    'companyName' => "PARQUETSOL",
                    'companyEmployeesCount' => "24",
                    'companySalaryWeight' => "58814.0",
                    'period' => "mois de septembre 2020",
                    'siret' => "31634350800024",
                    'address' => "   5    RUE JULES VERNE 69630 CHAPONOST",

                ],
            ],
        ];
    }
}
