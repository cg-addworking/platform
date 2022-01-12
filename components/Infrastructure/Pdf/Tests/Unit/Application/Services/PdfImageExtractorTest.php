<?php

namespace Components\Infrastructure\Pdf\Tests\Unit\Application\Services;

use Components\Infrastructure\Pdf\Application\Services\PdfImageExtractor;
use PHPUnit\Framework\TestCase;

class PdfImageExtractorTest extends TestCase
{
    public function testHasImages()
    {
        $file = new \SplFileInfo(__DIR__ . '/data/attestation-salarie-hors-ue.pdf');

        $this->assertTrue(
            (new PdfImageExtractor)->hasImages($file),
            "PDF '{$file->getPathname()}' should contain images"
        );
    }

    public function testListImages()
    {
        $file = new \SplFileInfo(__DIR__ . '/data/attestation-salarie-hors-ue.pdf');

        $this->assertEquals(
            [
                (object) [
                    "page" => "1",
                    "num" => "0",
                    "type" => "image",
                    "width" => "1656",
                    "height" => "2339",
                    "color" => "gray",
                    "comp" => "1",
                    "bpc" => "1",
                    "enc" => "ccitt",
                    "interp" => "no",
                    "object" => "4",
                    "ID" => "0",
                    "x-ppi" => "200",
                    "y-ppi" => "200",
                    "size" => "66.0K",
                    "ratio" => "14%",
                ],
                (object) [
                    "page" => "2",
                    "num" => "1",
                    "type" => "image",
                    "width" => "1656",
                    "height" => "2339",
                    "color" => "gray",
                    "comp" => "1",
                    "bpc" => "1",
                    "enc" => "ccitt",
                    "interp" => "no",
                    "object" => "9",
                    "ID" => "0",
                    "x-ppi" => "200",
                    "y-ppi" => "200",
                    "size" => "36.7K",
                    "ratio" => "7.8%",
                ]
            ],
            (new PdfImageExtractor)->listImages($file)
        );
    }

    public function testGetImages()
    {
        $file = new \SplFileInfo(__DIR__ . '/data/attestation-salarie-hors-ue.pdf');
        $count = 0;

        foreach ((new PdfImageExtractor)->getImages($file) as $image) {
            $count++;
            $this->assertInstanceOf(\SplFileInfo::class, $image);
            $this->assertTrue($image->isFile());
        }

        $this->assertEquals(2, $count);
    }
}
