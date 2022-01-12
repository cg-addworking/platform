<?php

namespace Components\Infrastructure\FileDataExtractor\Tests\Unit\Application\Services;

use Components\Infrastructure\FileDataExtractor\Application\Validators\ExtraitKbisValidationResponse;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorServiceInterface;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class DocumentValidatorServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @dataProvider checkProvider
     */
    public function testCheck(string $path, string $responseClass, array $data)
    {
        $service = $this->app->make(DocumentValidatorServiceInterface::class);

        $response = $service->check(new \SplFileInfo($path));

        $this->assertInstanceOf($responseClass, $response);
        $this->assertEquals($data, $response->toArray()['data']);
    }

    public function checkProvider()
    {
        return [
            'Kbis 1 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-1.pdf',
                'responseClass' => ExtraitKbisValidationResponse::class,
                'data' => [
                    'siret' => "523340388 RCS LILLE METROPOLE",
                    'name' => "SIPHOIDE NATIONALE TUYAUTERIE",
                    'date' => "2020-10-14T10:36",
                    'verification_key' => "hDvcZbNbOZ",
                ],
            ],
        ];
    }
}
