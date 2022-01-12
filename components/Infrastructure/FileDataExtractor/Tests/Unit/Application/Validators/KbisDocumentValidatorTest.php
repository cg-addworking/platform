<?php

namespace Components\Infrastructure\FileDataExtractor\Tests\Unit\Application\Validators;

use Components\Infrastructure\FileDataExtractor\Application\Validators\ExtraitKbisValidator;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class KbisDocumentValidatorTest extends TestCase
{
    use CreatesApplication;

    /**
     * @dataProvider checkDataProvider
     */
    public function testCheck(string $path, array $data)
    {
        $validator = $this->app->make(ExtraitKbisValidator::class);
        $response = $validator->checkProofOfAuthenticity(new \SplFileInfo($path));

        $this->assertTrue(
            $response->getScreenshot()->isReadable(),
        );

        $this->assertEquals(
            $data['siret_number'],
            $response->getSiret(),
        );

        $this->assertEquals(
            $data['name'],
            $response->getName(),
        );

        $this->assertEquals(
            $data['date'],
            $response->getDate(),
        );

        $this->assertEquals(
            $data['verification_key'],
            $response->getVerificationKey(),
        );
    }

    public function checkDataProvider()
    {
        return [
            'Kbis 1 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-1.pdf',
                'data' => [
                    'siret_number' => "523340388 RCS LILLE METROPOLE",
                    'name' => "SIPHOIDE NATIONALE TUYAUTERIE",
                    'date' => new \DateTime("2020-10-14T10:36"),
                    'verification_key' => "hDvcZbNbOZ",
                ],
            ],
        ];
    }
}
