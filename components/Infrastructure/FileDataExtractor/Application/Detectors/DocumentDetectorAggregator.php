<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Detectors;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorAggregatorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;
use Illuminate\Support\Facades\App;

class DocumentDetectorAggregator implements DocumentDetectorAggregatorInterface
{
    protected $items;

    public function __construct(iterable $detectors = [])
    {
        $this->items = new \SplDoublyLinkedList;

        if ($detectors) {
            $this->importDetectors($detectors);
        }
    }

    public function push(DocumentDetectorInterface $detector): void
    {
        $this->items->push($detector);
    }

    public function detect(\SplFileInfo $file): ?DocumentDetectorInterface
    {
        foreach ($this->items as $detector) {
            if ($detector->detect($file)) {
                return $detector;
            }
        }

        return null;
    }

    protected function importDetectors(iterable $detectors)
    {
        foreach ($detectors as $detector) {
            if (is_string($detector) && class_exists($detector, true)) {
                $detector = App::make($detector);
            }

            $this->push($detector);
        }
    }
}
