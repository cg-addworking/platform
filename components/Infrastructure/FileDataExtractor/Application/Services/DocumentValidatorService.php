<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Services;

use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\UndetectableDocumentException;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorAggregatorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorServiceInterface;

class DocumentValidatorService implements DocumentValidatorServiceInterface
{
    protected $detectors;
    protected $validatorFactory;

    public function __construct(
        DocumentDetectorAggregatorInterface $detectors,
        DocumentValidatorFactoryInterface $validatorFactory
    ) {
        $this->detectors = $detectors;
        $this->validatorFactory = $validatorFactory;
    }

    public function check(\SplFileInfo $file): DocumentValidationResponseInterface
    {
        $detector = $this->detectors->detect($file);

        if (is_null($detector)) {
            throw new UndetectableDocumentException($this, $file);
        }

        return $this->validatorFactory->makeFromDetector($detector)->check($file);
    }
}
