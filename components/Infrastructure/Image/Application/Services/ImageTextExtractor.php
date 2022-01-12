<?php

namespace Components\Infrastructure\Image\Application\Services;

use Components\Infrastructure\Image\Domain\Interfaces\ImageTextExtractorInterface;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Paragraph;
use Google\Cloud\Vision\V1\Symbol;
use Google\Cloud\Vision\V1\TextAnnotation;
use Google\Cloud\Vision\V1\TextAnnotation\DetectedBreak;
use Google\Cloud\Vision\V1\TextAnnotation\DetectedBreak\BreakType;

/**
 * Note: to be able to use this class you NEED to export the following
 * environment variable BEFORE running the PHP script:
 *
 *     export GOOGLE_APPLICATION_CREDENTIALS="<path>"
 *
 * where <path> is the path of the Google API key you generated.
 *
 * More details here: https://cloud.google.com/vision/docs/setup
 *
 * ----------------------------------------------------------------------------
 *
 * Note: to be able to read PDFs, you MUST specify a key that can
 * store stuff in the Google Bucket storage
 *
 * More details here: https://cloud.google.com/vision/docs/pdf
 */
class ImageTextExtractor implements ImageTextExtractorInterface
{
    protected $annotator;

    public function __construct()
    {
        $this->annotator = new ImageAnnotatorClient;
    }

    public function __destruct()
    {
        $this->annotator->close();
    }

    public function getText(\SplFileInfo $file): string
    {
        return $this->getAnnotation($file->getPathname())->getText();
    }

    protected function getAnnotation(string $image): TextAnnotation
    {
        $blob = is_readable($image) ? file_get_contents($image) : $image;

        $response = $this->annotator->textDetection($blob);
        $document = $response->getFullTextAnnotation();

        if (is_null($document)) {
            throw new \RuntimeException("unable to annotate image");
        }

        return $document;
    }

    protected function getContents(TextAnnotation $document): array
    {
        $paragraphs = [];

        foreach ($this->getParagraphs($document) as $paragraph) {
            $paragraphs[] = $this->getParagraphContent($paragraph);
        }

        return $paragraphs;
    }

    protected function getParagraphs(TextAnnotation $document): \Generator
    {
        foreach ($document->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                foreach ($block->getParagraphs() as $paragraph) {
                    yield $paragraph;
                }
            }
        }
    }

    protected function getParagraphContent(Paragraph $paragraph): string
    {
        $str = "";

        foreach ($paragraph->getWords() as $word) {
            foreach ($word->getSymbols() as $symbol) {
                $str .= $this->getTextFromSymbol($symbol);
            }
        }

        return $str;
    }

    protected function getTextFromSymbol(Symbol $symbol): string
    {
        $str = $symbol->getText();

        if (! is_null($property = $symbol->getProperty()) &&
            ! is_null($break = $property->getDetectedBreak())
        ) {
            $str .= $this->getBreakContent($break);
        }

        return $str;
    }

    protected function getBreakContent(DetectedBreak $break): string
    {
        switch ($break->getType()) {
            case BreakType::SPACE:
            case BreakType::SURE_SPACE:
            case BreakType::EOL_SURE_SPACE:
                return ' ';

            case BreakType::HYPHEN:
                return '-';

            case BreakType::LINE_BREAK:
                return PHP_EOL;

            default:
            case BreakType::UNKNOWN:
                return '';
        }
    }
}
