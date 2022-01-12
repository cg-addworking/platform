<?php

namespace Components\Infrastructure\FileDataExtractor\Tests\Unit\Application\Services;

use Components\Infrastructure\FileDataExtractor\Application\Detectors\KbisDetector;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\KbisDataExtractor;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class DocumentDataExtractorServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @dataProvider extractDataFromDataProvider
     */
    public function testExtractDataFrom(string $path, string $detector, string $extractor, array $data)
    {
        $service = $this->app->make(DocumentDataExtractorServiceInterface::class);

        $documentData = $service->extractDataFrom(new \SplFileInfo($path));

        $this->assertInstanceOf($detector, $documentData->getDetector());
        $this->assertInstanceOf($extractor, $documentData->getExtractor());
        $this->assertEquals($data, $documentData->toArray());
    }

    public function extractDataFromDataProvider()
    {
        return [
            'Kbis 1 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-1.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "523340388",
                    'company_name' => "SIPHOIDE NATIONALE TUYAUTERIE",
                    'date' => new \DateTime("2010-06-30"),
                    'verification_key' => "hDvcZbNbOZ",
                ],
            ],

            'Kbis 2 - image pdf - v-flipped' => [
                'path' => __DIR__ . '/data/kbis-2.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "799710652",
                    'company_name' => "C.E.F",
                    //'company_name' => "SARL COUVERTURE ETANCHEITE DE FRANCE",
                    'date' => new \DateTime("2014-02-03"),
                    'verification_key' => null,
                ],
            ],

            'Kbis 3 - image pdf - tilted' => [
                'path' => __DIR__ . '/data/kbis-3.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "511075905",
                    'company_name' => "ART CAMP",
                    'date' => new \DateTime("2009-03-18"),
                    'verification_key' => null,
                ],
            ],

            'Kbis 4 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-4.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "882019383",
                    'company_name' => "FRANCE FIBRE OPTIQUE",
                    'date' => new \DateTime("2020-02-26"),
                    'verification_key' => "YJv3baFN4M",
                ],
            ],

            'Kbis 5 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-5.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "479277063",
                    'company_name' => "SOCIETE NOUVELLE HYDROLOG",
                    'date' => new \DateTime("2004-11-02"),
                    'verification_key' => "kV5SxtONQO",
                ],
            ],

            'Kbis 6 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-6.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "443973128",
                    'company_name' => "GARCZYNSKI TRAPLOIR",
                    'date' => new \DateTime("2003-09-01"),
                    'verification_key' => "Y5muj9qtmv",
                ],
            ],

            'Kbis 7 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-7.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "815295894",
                    'company_name' => "SOMMET COUVRE",
                    'date' => new \DateTime("2015-12-16"),
                    'verification_key' => "wSdLnh28C1",
                ],
            ],

            'Kbis 8 - image pdf' => [
                'path' => __DIR__ . '/data/kbis-8.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "452854979",
                    'company_name' => "JARDINS DE BABYLONE",
                    'date' => new \DateTime("2010-04-13"),
                    'verification_key' => null,
                ],
            ],

            'Kbis 9 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-9.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "841410103",
                    'company_name' => "BBO SERVICES",
                    'date' => new \DateTime("2018-07-30"),
                    'verification_key' => null,
                ],
            ],

            'Kbis 10 - image pdf - a3 - rotate-left' => [
                'path' => __DIR__ . '/data/kbis-10.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "815339643",
                    'company_name' => null,
                    //'company_name' => "RENOV'BAT",
                    'date' => new \DateTime("2015-12-17"),
                    'verification_key' => "kVIRTDjLGq",
                ],
            ],

            'Kbis 11 - image pdf - skewed' => [
                'path' => __DIR__ . '/data/kbis-11.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "879256519",
                    'company_name' => "TP NOEL",
                    'date' => new \DateTime("2019-12-16"),
                    'verification_key' => "bPLVrpeBH3",
                ],
            ],

            'Kbis 12 - text pdf' => [
                'path' => __DIR__ . '/data/kbis-12.pdf',
                'detector' => KbisDetector::class,
                'extractor' => KbisDataExtractor::class,
                'data' => [
                    'siret_number' => "821558855",
                    'company_name' => "LEFEBVRE DETOUT CONSTRUCTIONS",
                    'date' => new \DateTime("2016-07-18"),
                    'verification_key' => "7FZfKl9AWm",
                ],
            ],
        ];
    }
}
