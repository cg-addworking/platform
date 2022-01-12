<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\UnableToMakeExtractor;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;
use Illuminate\Contracts\Container\Container;

class DocumentDataExtractorFactory implements DocumentDataExtractorFactoryInterface
{
    protected $container;
    protected $registry = [];

    public function __construct(Container $container, array $classes = [])
    {
        $this->container = $container;

        if ($classes) {
            foreach ($classes as $detector => $extractor) {
                $this->register($detector, $extractor);
            }
        }
    }

    public function register(string $detector, string $extractor)
    {
        if (! class_exists($detector)) {
            throw new \InvalidArgumentException("no such class '{$detector}'");
        }

        if (! class_exists($extractor)) {
            throw new \InvalidArgumentException("no such class '{$extractor}'");
        }

        if (! in_array(DocumentDetectorInterface::class, class_implements($detector))) {
            throw new \InvalidArgumentException(
                "detector class should implement " . DocumentDetectorInterface::class
            );
        }

        if (! in_array(DocumentDataExtractorInterface::class, class_implements($extractor))) {
            throw new \InvalidArgumentException(
                "extractor class should implement " . DocumentDataExtractorInterface::class
            );
        }

        $this->registry[$detector] = $extractor;
    }

    /**
     * @param DocumentDetectorInterface $detector
     * @throws UnableToMakeExtractor
     *
     * @return DocumentDataExtractorInterface
     */
    public function makeFromDetector(DocumentDetectorInterface $detector): DocumentDataExtractorInterface
    {
        $detectorClass = get_class($detector);

        if (! isset($this->registry[$detectorClass])) {
            throw new UnableToMakeExtractor($this, "no corresponding extractor found for '{$detectorClass}'");
        }

        $extractorClass = $this->registry[$detectorClass];

        try {
            return $this->container->make($extractorClass);
        } catch (\Exception $e) {
            throw new UnableToMakeExtractor($this, "unable to instanciate '{$extractorClass}'", $e);
        }
    }
}
