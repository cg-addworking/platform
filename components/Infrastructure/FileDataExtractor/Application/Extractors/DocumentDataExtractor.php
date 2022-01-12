<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\StringDataExtractorHelperInterface;
use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;

abstract class DocumentDataExtractor implements DocumentDataExtractorInterface
{
    protected $textExtractor;
    protected $dataExtractorHelper;

    public function __construct(
        TextExtractorServiceInterface $textExtractor,
        StringDataExtractorHelperInterface $dataExtractorHelper
    ) {
        $this->textExtractor       = $textExtractor;
        $this->dataExtractorHelper = $dataExtractorHelper;
    }

    protected function getTextExtractor(): TextExtractorServiceInterface
    {
        return $this->textExtractor;
    }
}
