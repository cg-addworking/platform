<?php

namespace Components\Infrastructure\Pdf\Tests\Unit\Application\Services;

use Components\Infrastructure\Pdf\Application\Services\PdfTextExtractor;
use PHPUnit\Framework\TestCase;

class PdfTextExtractorTest extends TestCase
{
    public function testHasText()
    {
        $file = new \SplFileInfo(__DIR__ . '/data/attestation-salarie-hors-ue.pdf');

        $this->assertFalse(
            (new PdfTextExtractor)->hasText($file),
            "File '{$file->getPathname()}' should only contains images"
        );

        $file = new \SplFileInfo(__DIR__ . '/data/kbis.pdf');

        $this->assertTrue(
            (new PdfTextExtractor)->hasText($file),
            "File '{$file->getPathname()}' should contains text and images"
        );
    }

    public function testgetText()
    {
        $file = new \SplFileInfo(__DIR__ . '/data/kbis.pdf');

        $this->assertStringContainsString(
            "EXTRAIT D'IMMATRICULATION PRINCIPALE AU REGISTRE DU COMMERCE ET DES SOCIETES",
            (new PdfTextExtractor)->getText($file),
        );

        $this->assertStringContainsString(
            "LEFEBVRE DETOUT CONSTRUCTIONS",
            (new PdfTextExtractor)->getText($file),
        );
    }
}
