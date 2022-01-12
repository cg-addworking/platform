<?php

namespace Components\Infrastructure\Text\Tests\Unit\Application\Services;

use Components\Infrastructure\Image\Application\Services\ImageTextExtractor;
use Components\Infrastructure\Pdf\Application\Services\PdfImageConverter;
use Components\Infrastructure\Pdf\Application\Services\PdfImageExtractor;
use Components\Infrastructure\Pdf\Application\Services\PdfTextExtractor;
use Components\Infrastructure\Text\Application\Services\TextExtractorService;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class TextExtractorServiceTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $root = realpath(__DIR__ . '/../../../../../../../');

        $dotenv = Dotenv::createImmutable($root);
        $dotenv->load();
    }

    /**
     * @dataProvider getContentsDataProvider
     */
    public function testGetContents(string $path, array $contents)
    {
        $file = new \SplFileInfo($path);

        $extractor = new TextExtractorService(
            new PdfTextExtractor,
            new PdfImageExtractor,
            new PdfImageConverter,
            new ImageTextExtractor,
        );

        $text = $extractor->getContents($file);

        foreach ($contents as $expected) {
            $this->assertStringContainsString($expected, $text);
        }
    }

    /**
     * @dataProvider getContentsDataProvider
     */
    public function testGetLines(string $path, array $contents)
    {
        $file = new \SplFileInfo($path);

        $extractor = new TextExtractorService(
            new PdfTextExtractor,
            new PdfImageExtractor,
            new PdfImageConverter,
            new ImageTextExtractor,
        );

        $lines = $extractor->getLines($file);

        foreach ($contents as $line) {
            $this->assertContains($line, $lines);
        }
    }

    public function getContentsDataProvider()
    {
        return [
            'plain text file' => [
                'path' => __DIR__ . '/data/file.txt',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],

            'pdf with text' => [
                'path' => __DIR__ . '/data/file-with-text.pdf',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],

            'pdf with images' => [
                'path' => __DIR__ . '/data/file-with-image.pdf',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],

            'image' => [
                'path' => __DIR__ . '/data/file.jpg',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],
        ];
    }
}
