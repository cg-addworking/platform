<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Exceptions;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;

class UndetectableDocumentException extends \RuntimeException
{
    protected const MESSAGE = "unable to detect the document type for file '%s'";

    protected $service;

    public function __construct(
        DocumentDataExtractorServiceInterface $service,
        \SplFileInfo $file
    ) {
        $this->service = $service;

        parent::__construct(
            sprintf(self::MESSAGE, $file->getPathname())
        );
    }

    public function getService(): DocumentDataExtractorServiceInterface
    {
        return $this->service;
    }
}
