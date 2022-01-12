<?php

namespace Components\Infrastructure\Image\Tests\Unit\Application\Services;

use Components\Infrastructure\Image\Application\Services\ImageTextExtractor;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ImageTextExtractorTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $root = realpath(__DIR__ . '/../../../../../../../');

        $dotenv = Dotenv::createImmutable($root);
        $dotenv->load();
    }

    /**
     * @dataProvider getTextDataProvider
     */
    public function testGetText(string $path, array $lines)
    {
        $file = new \SplFileInfo($path);
        $extractor = new ImageTextExtractor;

        $result = $extractor->getText($file);

        foreach ($lines as $expected) {
            $this->assertStringContainsString($expected, $result);
        }
    }

    public function getTextDataProvider()
    {
        return [
            'text' => [
                'path' => __DIR__ . '/data/text.png',
                'text' => [
                    'This is the first line of',
                    'this text example.',
                    'This is the second line',
                    'of the same text.',
                ],
            ],

            'typefaces' => [
                'path' => __DIR__ . '/data/typefaces.jpg',
                'text' => [
                    'Selecting',
                    'TYPEFACES',
                    'for body text',
                ],
            ],
        ];
    }
}
