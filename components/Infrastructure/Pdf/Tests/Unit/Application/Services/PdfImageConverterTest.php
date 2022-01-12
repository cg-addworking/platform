<?php

namespace Components\Infrastructure\Pdf\Tests\Unit\Application\Services;

use Components\Infrastructure\Pdf\Application\Services\PdfImageConverter;
use PHPUnit\Framework\TestCase;

class PdfImageConverterTest extends TestCase
{
    public function testConvert()
    {
        $converter = new PdfImageConverter;
        $image = $converter->convert(new \SplFileInfo(__DIR__ . '/data/kbis.pdf'));

        $this->assertInstanceof(\SplFileInfo::class, $image);
        $this->assertGreaterThan(0, $image->getSize());
        $this->assertEquals('image/jpeg', mime_content_type($image->getPathname()));
    }
}
