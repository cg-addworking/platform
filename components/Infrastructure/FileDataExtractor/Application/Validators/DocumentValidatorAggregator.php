<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorAggregatorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorAggregatorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Illuminate\Support\Facades\App;

class DocumentValidatorAggregator implements DocumentValidatorAggregatorInterface
{
    protected $items;

    public function __construct(iterable $validators = [])
    {
        $this->items = new \SplDoublyLinkedList;

        if ($validators) {
            $this->importValidators($validators);
        }
    }

    public function push(DocumentValidatorInterface $validator): void
    {
        $this->items->push($validator);
    }

    public function detect(\SplFileInfo $file): ?DocumentValidatorInterface
    {
        foreach ($this->items as $validator) {
            if ($validator->detect($file)) {
                return $validator;
            }
        }

        return null;
    }

    protected function importValidators(iterable $validators)
    {
        foreach ($validators as $validator) {
            if (is_string($validator) && class_exists($validator, true)) {
                $validator = App::make($validator);
            }

            $this->push($validator);
        }
    }
}
