<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Services;

use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\UndetectableDocumentException;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorAggregatorInterface;

class DocumentDataExtractorService implements DocumentDataExtractorServiceInterface
{
    protected $detectors;
    protected $extractorFactory;

    public function __construct(
        DocumentDetectorAggregatorInterface $detectors,
        DocumentDataExtractorFactoryInterface $extractorFactory
    ) {
        $this->detectors = $detectors;
        $this->extractorFactory = $extractorFactory;
    }

    public function extractDataFrom(\SplFileInfo $file): ?DocumentDataInterface
    {
        $detector = $this->detectors->detect($file);

        if (is_null($detector)) {
//            throw new UndetectableDocumentException($this, $file);
            return null;
        }

        $extractor = $this->extractorFactory->makeFromDetector($detector);

        $data = $extractor->extract($file);
        $data->setDetector($detector);

        return $data;
    }
}
